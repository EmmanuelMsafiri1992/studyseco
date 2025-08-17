<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'lesson_id',
        'watch_time_seconds',
        'completion_percentage',
        'is_completed',
        'first_watched_at',
        'last_watched_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'first_watched_at' => 'datetime',
        'last_watched_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(VideoLesson::class, 'lesson_id');
    }
}
