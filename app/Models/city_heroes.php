<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class city_heroes extends Model
{
    protected $table = 'city';

    protected $fillable = [
        'city',
        'description',
        'type',
        'added_user_id',
        'added_user_name'
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

    //-----------------------------
    // Communication with the user
    //-----------------------------
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'added_user_id');
    }


    
}
