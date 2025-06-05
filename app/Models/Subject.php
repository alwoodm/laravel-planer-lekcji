<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    /**
     * Atrybuty, które można masowo przypisywać
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * Pobiera wszystkie lekcje dla danego przedmiotu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
