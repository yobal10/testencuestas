<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /** @use HasFactory<\Database\Factories\VoteFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'poll_id',
        'candidate_id',
        'vote_type',
        'ip_address',
        'user_agent',
        'poll_token',
        'fingerprint',
        'session_id',
        'composite_hash',
        'is_suspicious',
    ];

    protected function casts(): array
    {
        return [
            'is_suspicious' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($vote) {
            do {
                $code = strtoupper(str()->random(10));
            } while (self::where('code', $code)->exists());

            $vote->code = $code;

            $vote->composite_hash = hash('sha256',
                $vote->poll_id .
                $vote->fingerprint .
                $vote->poll_token .
                $vote->ip_address .
                $vote->user_agent
            );
        });
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
