<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicCourse extends Model
{
    use HasFactory;

    protected $fillable = ['program_id', 'code', 'name', 'semester_level', 'credits', 'is_active'];

    protected function casts(): array
    {
        return ['semester_level' => 'integer', 'credits' => 'decimal:1', 'is_active' => 'boolean'];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(AcademicProgram::class, 'program_id');
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class, 'course_id');
    }
}
