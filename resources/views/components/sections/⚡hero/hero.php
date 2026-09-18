<?php

use App\Models\Candidate;
use App\Models\PoliticalParty;
use App\Models\Poll;
use App\Models\User;
use App\Models\Vote;
use Livewire\Component;

new class extends Component
{
    public int $totalPolls = 0;
    public int $totalParticipants = 0;
    public int $totalVotes = 0;
    public int $totalPoliticalParties = 0;
    public int $totalCandidates = 0;

    public function mount(): void
    {
        $this->totalPolls = Poll::count();
        $this->totalParticipants = User::count();
        $this->totalVotes = Vote::count();
        $this->totalPoliticalParties = PoliticalParty::count();
        $this->totalCandidates = Candidate::count();
    }
};
