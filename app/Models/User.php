<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static Builder student()
 * @method static Builder teacher()
 * @method static Builder admin()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'district',
        'region',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // -- Accessors and Mutators --

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // -- Scopes --

    /**
     * Scope a query to only include students.
     */
    public function scopeStudent(Builder $query): Builder
    {
        return $query->where('role', 'student');
    }

    /**
     * Scope a query to only include teachers.
     */
    public function scopeTeacher(Builder $query): Builder
    {
        return $query->where('role', 'teacher');
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    // -- Relationships --

    /**
     * Get the user profile associated with the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the topics taught by the user (if a teacher).
     */
    public function teacherTopics(): HasMany
    {
        return $this->hasMany(Topic::class, 'teacher_id');
    }

    /**
     * Get the video lessons taught by the user (if a teacher).
     */
    public function teacherLessons(): HasMany
    {
        return $this->hasMany(VideoLesson::class, 'teacher_id');
    }

    /**
     * Get the live sessions hosted by the user (if a teacher).
     */
    public function teacherSessions(): HasMany
    {
        return $this->hasMany(LiveSession::class, 'teacher_id');
    }

    /**
     * Get the live sessions the user has participated in (if a student).
     */
    public function liveSessionParticipants(): HasMany
    {
        return $this->hasMany(LiveSessionParticipant::class, 'student_id');
    }

    /**
     * Get the subscriptions for the student.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(StudentSubscription::class, 'student_id');
    }

    /**
     * Get the payments made by the user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    /**
     * Get the quizzes created by the user (if a teacher).
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'teacher_id');
    }

    /**
     * Get the quiz attempts made by the user (if a student).
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }

    /**
     * Get the assignments created by the user (if a teacher).
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    /**
     * Get the assignment submissions by the user (if a student).
     */
    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    /**
     * Get the progress records for the user.
     */
    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentProgress::class, 'student_id');
    }

    /**
     * Get the lesson progress records for the user.
     */
    public function lessonProgress(): HasMany
    {
        return $this->hasMany(LessonProgress::class, 'student_id');
    }

    /**
     * Get the grades for the student.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class, 'student_id');
    }

    /**
     * Get the forum topics created by the user.
     */
    public function forumTopics(): HasMany
    {
        return $this->hasMany(ForumTopic::class, 'user_id');
    }

    /**
     * Get the forum posts created by the user.
     */
    public function forumPosts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'user_id');
    }

    /**
     * Get the private messages sent by the user.
     */
    public function privateMessagesSent(): HasMany
    {
        return $this->hasMany(PrivateMessage::class, 'sender_id');
    }

    /**
     * Get the private messages received by the user.
     */
    public function privateMessagesReceived(): HasMany
    {
        return $this->hasMany(PrivateMessage::class, 'recipient_id');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the activity logs for the user.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    /**
     * Get the achievements for the user.
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }
}
