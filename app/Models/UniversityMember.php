<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniversityMember extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'faculty_id', 'program_id', 'member_type', 'institutional_code', 'phone', 'status', 'profile_data'];

    protected function casts(): array
    {
        return ['profile_data' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(AcademicProgram::class, 'program_id');
    }
}
