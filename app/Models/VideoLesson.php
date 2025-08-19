<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class VideoLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'teacher_id',
        'title',
        'description',
        'video_url',
        'thumbnail',
        'duration_seconds',
        'is_preview',
        'order_index',
        'views_count',
        'is_active',
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the topic that owns the video lesson.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get the teacher who created the lesson.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the attachments for the lesson.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(LessonAttachment::class, 'lesson_id');
    }

    /**
     * Get the student progress records for the lesson.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class, 'lesson_id');
    }
}
