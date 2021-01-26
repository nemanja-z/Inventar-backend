<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Events\Registered;
use App\Notifications\VerifyUserEmail;

class User extends Authenticatable
{
    use \Illuminate\Notifications\Notifiable;

    protected $fillable = [
        'name',
        'password',
        'email',
        'profile',
        'phone'

    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function sendEmailVerificationNotification()
        {
            $this->notify(new VerifyUserEmail);
        }
}
