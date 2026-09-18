<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /** @use HasFactory<\Database\Factories\CandidateFactory> */
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'political_party_id',
        'name',
        'slug',
        'photo',
        'biography',
        'number',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function politicalParty()
    {
        return $this->belongsTo(PoliticalParty::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
