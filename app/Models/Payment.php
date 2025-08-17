<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'student_id',
        'payment_method_id',
        'amount',
        'currency',
        'reference_number',
        'admin_reference',
        'sender_name',
        'sender_phone',
        'payment_date',
        'payment_time',
        'notes',
        'admin_notes',
        'status',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'proof_of_payment',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'verified_at' => 'datetime',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(StudentSubscription::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
