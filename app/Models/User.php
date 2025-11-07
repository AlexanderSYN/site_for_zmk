<?php

namespace App\Models;

//========================================
// Communicate with the base date user
// Связь с базой данных user
//========================================

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'id',
        'first_name',
        'last_name',
        'patronymic',
        'email',
        'login',
        'password',
        'isBan',
        'isAdmin'
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
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'password' => 'hashed',
            'isBan' => 'boolean',
            'isAdmin' => 'boolean'
        ];
    }


    //
    // to check if the user is blocked or whether he is an administrator
    //

    //check ban
    public function isBanned() : bool {
        return $this->isBan === true;
    }

    //check admin
    public function isAdmin() : bool {
        return $this->isAdmin() === true;
    }
}
