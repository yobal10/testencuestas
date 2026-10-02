<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['created_by', 'academic_period_id', 'faculty_id', 'program_id', 'course_id', 'title', 'slug', 'description', 'survey_type', 'audience', 'status', 'is_anonymous', 'opens_at', 'closes_at', 'settings'];

    protected function casts(): array
    {
        return ['is_anonymous' => 'boolean', 'opens_at' => 'datetime', 'closes_at' => 'datetime', 'settings' => 'array'];
    }

    public function scopeAvailableForResponses(Builder $query): Builder
    {
        return $query->whereIn('status', ['published', 'active'])
            ->where(fn (Builder $query) => $query->whereNull('opens_at')->orWhere('opens_at', '<=', now()))
            ->where(fn (Builder $query) => $query->whereNull('closes_at')->orWhere('closes_at', '>=', now()));
    }

    public function acceptsResponses(): bool
    {
        return in_array($this->status, ['published', 'active'], true)
            && (! $this->opens_at || $this->opens_at->lessThanOrEqualTo(now()))
            && (! $this->closes_at || $this->closes_at->greaterThanOrEqualTo(now()));
    }

    public function getSurveyTypeLabelAttribute(): string
    {
        return match ($this->survey_type) {
            'student_experience' => 'Experiencia estudiantil',
            'teacher_evaluation' => 'Evaluación docente',
            'course_evaluation' => 'Evaluación de curso',
            'service_evaluation' => 'Evaluación de servicios',
            'institutional' => 'Institucional',
            default => 'Encuesta universitaria',
        };
    }

    public function getAudienceLabelAttribute(): string
    {
        return match ($this->audience) {
            'students' => 'Estudiantes',
            'teachers' => 'Docentes',
            'staff' => 'Personal administrativo',
            'all' => 'Comunidad universitaria',
            default => 'Comunidad universitaria',
        };
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id');
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(AcademicProgram::class, 'program_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AcademicCourse::class, 'course_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class)->orderBy('sort_order');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
