<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_email',
        'recipient_name',
        'subject',
        'body',
        'template_id',
        'template_data',
        'priority',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'template_data' => 'array',
        'sent_at' => 'datetime',
    ];
}
