<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'form_id',
        'teacher_id',
        'name',
        'slug',
        'description',
        'order',
    ];

    /**
     * Get the subject that owns the topic.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the form that owns the topic.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the teacher that created the topic.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the video lessons for the topic.
     */
    public function videoLessons()
    {
        return $this->hasMany(VideoLesson::class);
    }
}
