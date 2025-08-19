<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subject_id',
        'form_id',
        'user_id',
        'title',
        'content',
        'is_pinned',
        'is_locked',
        'views_count',
        'replies_count',
        'last_reply_at',
        'last_reply_by',
        'is_active',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'is_active' => 'boolean',
        'last_reply_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastReplyBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_reply_by');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'topic_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ForumLike::class, 'likeable_id')->where('likeable_type', 'App\\Models\\ForumTopic');
    }
}
