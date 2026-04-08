<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'nama',
        'email', 
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false; // tabel tidak punya created_at/updated_at
}