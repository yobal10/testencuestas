<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliticalParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'acronym',
        'logo',
        'color',
        'description',
        'website',
    ];

    protected function casts(): array
    {
        return [

        ];
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
