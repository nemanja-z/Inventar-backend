<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class User extends Model implements Authenticatable
{
    use AuthenticableTrait;
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
}
