<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantBiography extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_title',
        'bio',
        'specialties',
        'education',
        'certifications',
        'work_experience',
        'languages',
        'services_offered',
        'consultation_methods',
        'test_commission_percentage',
        'approach',
        'availability',
        'phone',
        'email',
        'social_media',
        'website',
        'achievements',
        'is_public',
        'priority',
    ];

    protected $casts = [
        'specialties' => 'array',
        'education' => 'array',
        'certifications' => 'array',
        'work_experience' => 'array',
        'languages' => 'array',
        'consultation_methods' => 'array',
        'availability' => 'array',
        'social_media' => 'array',
        'is_public' => 'boolean',
        'priority' => 'integer',
        'test_commission_percentage' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSpecialtiesListAttribute(): string
    {
        return is_array($this->specialties) ? implode('، ', $this->specialties) : '';
    }

    public function getLanguagesListAttribute(): string
    {
        return is_array($this->languages) ? implode('، ', $this->languages) : '';
    }

    public function getConsultationMethodsListAttribute(): string
    {
        return is_array($this->consultation_methods) ? implode('، ', $this->consultation_methods) : '';
    }
}
