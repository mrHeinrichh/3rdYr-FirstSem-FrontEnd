<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'firstName',
        'lastName',
        'age',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}