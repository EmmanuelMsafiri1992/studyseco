<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'parent_post_id',
        'user_id',
        'content',
        'likes_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ForumTopic::class);
    }

    public function parentPost(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'parent_post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function childrenPosts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'parent_post_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ForumLike::class, 'likeable_id')->where('likeable_type', 'App\\Models\\ForumPost');
    }
}
