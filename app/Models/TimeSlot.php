<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSlot extends Model
{
    use HasFactory;

    /**
     * Atrybuty, które można masowo przypisywać
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'period_number',
    ];

    /**
     * Atrybuty, które powinny być rzutowane
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Pobiera wszystkie lekcje dla danej godziny lekcyjnej
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Pobiera sformatowany czas w postaci "08:00 - 08:45"
     *
     * @return string
     */
    public function getFormattedTimeAttribute(): string
    {
        return "{$this->start_time->format('H:i')} - {$this->end_time->format('H:i')}";
    }
}
