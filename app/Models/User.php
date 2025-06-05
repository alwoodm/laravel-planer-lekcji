<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }
    
    /**
     * Sprawdza czy użytkownik ma rolę administratora
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    /**
     * Sprawdza czy użytkownik ma rolę nauczyciela
     *
     * @return bool
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }
    
    /**
     * Sprawdza czy użytkownik ma rolę ucznia
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
    
    /**
     * Pobiera wszystkie lekcje prowadzone przez nauczyciela
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }
    
    /**
     * Pobiera wszystkie klasy, do których należy uczeń
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(
            SchoolClass::class, 
            'student_class_assignments', 
            'user_id', 
            'class_id'
        )->withTimestamps();
    }
}
