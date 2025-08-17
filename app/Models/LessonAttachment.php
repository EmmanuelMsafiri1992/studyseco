<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'name',
        'file_path',
        'file_size',
        'mime_type',
        'type',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(VideoLesson::class);
    }
}
