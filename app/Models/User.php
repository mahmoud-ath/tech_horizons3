<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;








class User extends Authenticatable 
{
    use HasFactory;
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'user_name',
        'email',
        'email_verified_at',
        'usertype',
        'password',
        'gender',
        'remember_token',
        'user_image', // Ensure this matches your database
        
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
}


