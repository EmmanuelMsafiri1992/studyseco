<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveSessionParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'joined_at',
        'left_at',
        'attended',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'attended' => 'boolean',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(LiveSession::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
