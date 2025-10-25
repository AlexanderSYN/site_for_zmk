<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class heroes_added_by_user extends Model
{
    protected $table = 'heroes';

    protected $fillable = [
        'id',
        'name_hero',
        'description_hero',
        'hero_link',
        'city',
        'type',
        'image_hero',
        'image_qr',
        'added_user_id',
        'isCheck'
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
