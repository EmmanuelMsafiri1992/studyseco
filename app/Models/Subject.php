<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subjects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'code',
        'subject_code',
    ];

    /**
     * The forms that belong to the subject.
     */
    public function forms()
    {
        return $this->belongsToMany(Form::class, 'form_subjects');
    }

    /**
     * Get the topics for the subject.
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
