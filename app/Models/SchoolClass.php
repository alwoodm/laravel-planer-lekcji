<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    /**
     * Nazwa tabeli w bazie danych
     *
     * @var string
     */
    protected $table = 'classes';

    /**
     * Atrybuty, które można masowo przypisywać
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'year_level',
        'academic_year',
    ];

    /**
     * Pobiera wszystkie lekcje dla danej klasy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    /**
     * Pobiera wszystkich uczniów należących do klasy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'student_class_assignments',
            'class_id',
            'user_id'
        )->withTimestamps();
    }

    /**
     * Pobiera pełną nazwę klasy w formacie "nazwa (rok akademicki)"
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} ({$this->academic_year})";
    }
}
