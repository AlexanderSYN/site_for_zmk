<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class city_heroes_vov extends Model
{
    protected $table = 'city_heroes_vov';

    protected $fillable = [
        'city',
        'user_added',
        'user_added_id'
    ];

    //-----------------------------
    // Communication with the user
    //-----------------------------
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
