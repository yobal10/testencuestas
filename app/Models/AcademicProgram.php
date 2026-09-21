<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicProgram extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_id', 'name', 'code', 'slug', 'degree_level', 'duration_semesters', 'is_active'];

    protected function casts(): array
    {
        return ['duration_semesters' => 'integer', 'is_active' => 'boolean'];
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(AcademicCourse::class, 'program_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(UniversityMember::class, 'program_id');
    }
}
