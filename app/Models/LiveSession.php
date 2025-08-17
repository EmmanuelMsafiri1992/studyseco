<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'form_id',
        'topic_id',
        'title',
        'description',
        'scheduled_at',
        'duration_minutes',
        'meeting_url',
        'meeting_id',
        'password',
        'max_participants',
        'status',
        'recording_url',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(LiveSessionParticipant::class, 'session_id');
    }
}
