<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'imagepath','user_id','status'];

public function subscriptions()
{
    return $this->hasMany(Subscription::class);
}
}
