<?php

use App\Models\Candidate;
use App\Models\Poll;
use App\Models\Vote;
use App\Support\SiteSettings;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

new class extends Component
{
    public ?Poll $poll;
    public int|string|null $selectedCandidate = null;
    public ?string $selectedCandidateName = null;
    public ?string $vote_type = null;
    public ?Vote $userVote = null;
    public ?string $clientFingerprint = null;

    public $chartData = [];

    public function mount(Poll $poll): void
    {
        abort_if(
            in_array($poll->status, ['borrador', 'archivado'], true),
            404
        );

        $this->poll = $poll->load([
            'category',
            'candidates.politicalParty',
            'candidates.votes',
            'votes'
        ]);

        $this->ensurePollToken();
        $this->checkExistingVote();

        $this->loadChartData();
    }

    public function updatedClientFingerprint($value)
    {
        if ($value) {
            $this->checkExistingVote();
        }
    }

    protected function ensurePollToken(): void
    {
        $cookieName = "poll_token_{$this->poll->id}";

        if (!request()->cookie($cookieName)) {
            $token = hash_hmac(
                'sha256',
                $this->poll->id . request()->ip() . request()->userAgent(),
                config('app.key')
            );

            Cookie::queue($cookieName, $token, 60 * 24 * 365);
        }
    }

    protected function getPollToken(): ?string
    {
        return request()->cookie("poll_token_{$this->poll->id}");
    }

    protected function checkExistingVote(): void
    {
        $this->userVote = Vote::where('poll_id', $this->poll->id)
            ->where(function ($q) {
                if ($this->clientFingerprint) {
                    $q->orWhere('fingerprint', $this->clientFingerprint);
                }

                if ($this->getPollToken()) {
                    $q->orWhere('poll_token', $this->getPollToken());
                }

                $q->orWhere('session_id', session()->getId());
            })
            ->first();
    }

    public function loadChartData()
    {
        $totalVotosValidos = $this->poll->votes()
            ->where('vote_type', 'válido')
            ->count();

        $votosNoSabe = $this->poll->votes()
            ->where('vote_type', 'no sabe')
            ->count();

        $votosNinguno = $this->poll->votes()
            ->where('vote_type', 'ninguno')
            ->count();

        $totalVotos = $totalVotosValidos + $votosNoSabe + $votosNinguno;

        $candidatosData = $this->poll->candidates->map(function ($candidate) use ($totalVotos) {
            $votos = $candidate->votes()->where('vote_type', 'válido')->count();
            $porcentaje = $totalVotos > 0 ? round(($votos / $totalVotos) * 100, 1) : 0;

            return [
                'id' => $candidate->id,
                'nombre' => $candidate->name,
                'votos' => $votos,
                'porcentaje' => $porcentaje,
                'foto' => $candidate->photo ? Storage::disk('candidates_photos')->url($candidate->photo) : null,
                'partido_nombre' => $candidate->politicalParty->name,
                'partido_acronimo' => $candidate->politicalParty->acronym,
                'partido_logo' => $candidate->politicalParty->logo ? Storage::disk('logos')->url($candidate->politicalParty->logo) : null,
                'color' => $candidate->politicalParty->color ?? '#6B7280',
            ];
        })->sortByDesc('porcentaje')->values();

        $noSabeData = [
            'nombre' => 'No sabe / No Opina',
            'votos' => $votosNoSabe,
            'porcentaje' => $totalVotos > 0 ? round(($votosNoSabe / $totalVotos) * 100, 1) : 0,
            'foto' => null,
            'partido_nombre' => '',
            'partido_acronimo' => '',
            'partido_logo' => null,
            'color' => '#283344',
        ];

        $otrosData = [
            'nombre' => 'Ninguno de los anteriores',
            'votos' => $votosNinguno,
            'porcentaje' => $totalVotos > 0 ? round(($votosNinguno / $totalVotos) * 100, 1) : 0,
            'foto' => null,
            'partido_nombre' => '',
            'partido_acronimo' => '',
            'partido_logo' => null,
            'color' => '#9CA3AF',
        ];

        $this->chartData = [
            'candidatos' => $candidatosData->toArray(),
            'no_sabe' => $noSabeData,
            'otros' => $otrosData,
            'total_votos' => $totalVotos,
        ];
    }

    public function selectedVote(int|string $candidate): void
    {
        if ($candidate === 'no sabe' || $candidate === 'ninguno') {
            $this->selectedCandidate = null;
            $this->vote_type = $candidate;
            $this->selectedCandidateName = ucfirst($candidate);
        } else {
            $candidateModel = Candidate::findOrFail($candidate);
            $this->selectedCandidate = $candidate;
            $this->vote_type = 'válido';
            $this->selectedCandidateName = $candidateModel->name;
        }

        Flux::modal('modal-vote')->show();
    }

    public function vote()
    {
        $ip = request()->ip();
        $fingerprint = $this->clientFingerprint;
        $pollToken = $this->getPollToken();
        $sessionId = session()->getId();

        $rateKey = 'vote:' . sha1($ip . $fingerprint . $this->poll->id);

        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            $seconds = RateLimiter::availableIn($rateKey);
            Flux::toast(
                "Demasiados intentos en esta encuesta. Espera {$seconds} segundos.",
                variant: 'danger'
            );
            return;
        }

        RateLimiter::hit($rateKey, 300);

        $this->validate([
            'selectedCandidate' => 'nullable|exists:candidates,id',
            'vote_type' => 'required|in:no sabe,ninguno,válido',
            'clientFingerprint' => 'required|string|min:64',
        ]);

        if ($this->vote_type === 'válido' && !$this->selectedCandidate) {
            Flux::toast('Debes seleccionar una opción para votar.', variant: 'warning');
            return;
        }

        $this->userVote = Vote::where('poll_id', $this->poll->id)
            ->where(function ($q) use ($fingerprint, $pollToken, $sessionId) {
                $q->where('fingerprint', $fingerprint)
                    ->orWhere('poll_token', $pollToken)
                    ->orWhere('session_id', $sessionId);
            })
            ->first();

        if ($this->userVote) {
            Flux::toast('Ya has votado en esta encuesta.', variant: 'warning');
            Flux::modal('modal-vote')->close();
            return;
        }

        $suspicious = Vote::where('ip_address', $ip)
            ->where('created_at', '>=', Carbon::now()->subMinutes(2))
            ->count() > 5;

        try {
            $vote = Vote::create([
                'poll_id' => $this->poll->id,
                'candidate_id' => $this->selectedCandidate,
                'vote_type' => $this->vote_type,
                'ip_address' => $ip,
                'user_agent' => request()->userAgent(),
                'fingerprint' => $fingerprint,
                'poll_token' => $pollToken,
                'session_id' => session()->getId(),
                'is_suspicious' => $suspicious
            ]);

            $this->userVote = $vote;

            $this->poll = $this->poll->fresh([
                'category',
                'candidates.politicalParty',
                'candidates.votes',
                'votes'
            ]);

            $this->reset(['selectedCandidate', 'vote_type', 'clientFingerprint']);

            Flux::modal('modal-vote')->close();

            Flux::toast('¡Tu voto ha sido registrado exitosamente!', variant: 'success');

            $this->loadChartData();

            $this->dispatch('chart-updated');
        } catch (\Illuminate\Database\QueryException $e) {
            Flux::toast('Ya registramos un voto tuyo previamente.', variant: 'warning');
        }
    }

    public function getTotalVotesProperty(): int
    {
        return $this->poll->votes()->count();
    }

    public function getKnowVotesProperty(): int
    {
        return $this->poll->votes()->where('vote_type', 'no sabe')->count();
    }

    public function getNoneVotesProperty(): int
    {
        return $this->poll->votes()->where('vote_type', 'ninguno')->count();
    }

    public function getValidVotesProperty(): int
    {
        return $this->poll->votes()->where('vote_type', 'válido')->count();
    }

    public function isVotedCandidate(int $candidateId): bool
    {
        return $this->userVote?->candidate_id === $candidateId;
    }

    public function isSpecialVote(string $type): bool
    {
        return $this->userVote?->vote_type === $type;
    }

    public function getIsPollClosedProperty(): bool
    {
        return ($this->poll->ends_at && $this->poll->ends_at->isPast()) 
           || $this->poll->status === 'cerrado';
    }

    public function render(): View
    {
        return $this->view()
            ->layout('layouts::app', [
                'title' => $this->poll->title . ' - ' . SiteSettings::get('site_name', config('app.name')),
                'description' => $this->poll->description,
                'image' => $this->poll->image ? Storage::disk('polls')->url($this->poll->image) : null,
            ]);
    }
};
