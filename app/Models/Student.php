<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'studentID',
        'studentName',
        'password',
        'email',
        'programDetailsID',
        'remember_token',
        'is_email_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
