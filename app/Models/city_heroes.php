<?php

namespace App\Models;

//================================================
// Communicate with the base date city
// Связь с базой данных city
//================================================

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class city_heroes extends Model
{
    protected $table = 'city';

    protected $fillable = [
        'id',
        'city',
        'description',
        'type',
        'added_user_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    //--------------------------------
    // Communication with bd the user
    // связь с бд user
    //--------------------------------
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'added_user_id');
    }

    //--------------------------------
    // Communication with bd the city
    // связь с бд city
    //--------------------------------
    public function city_relation() : BelongsTo
    {
        return $this->belongsTo(city_heroes::class, 'city');
    }

    
}
