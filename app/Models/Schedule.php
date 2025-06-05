<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    /**
     * Atrybuty, które można masowo przypisywać
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_id',
        'subject_id',
        'user_id',
        'time_slot_id',
        'day_of_week',
        'room',
    ];

    /**
     * Pobiera klasę dla danej lekcji
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Pobiera przedmiot dla danej lekcji
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Pobiera nauczyciela dla danej lekcji
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Pobiera godzinę lekcyjną dla danej lekcji
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    /**
     * Zakres zapytania dla dni tygodnia (poniedziałek-piątek)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForWeek(Builder $query): Builder
    {
        return $query->whereIn('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
    }

    /**
     * Sprawdza czy istnieje konflikt w planie lekcji dla danego nauczyciela
     *
     * @param int $teacherId ID nauczyciela
     * @param int $timeSlotId ID godziny lekcyjnej
     * @param string $dayOfWeek Dzień tygodnia
     * @param int|null $excludeId ID lekcji do pominięcia przy sprawdzaniu (np. przy edycji)
     * @return bool Czy istnieje konflikt (true) czy nie (false)
     */
    public static function hasConflict(int $teacherId, int $timeSlotId, string $dayOfWeek, ?int $excludeId = null): bool
    {
        $query = self::query()
            ->where('user_id', $teacherId)
            ->where('time_slot_id', $timeSlotId)
            ->where('day_of_week', $dayOfWeek);
            
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}
