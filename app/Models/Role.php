<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Define the table associated with the model (optional if the table name follows Laravel's convention)
    protected $table = 'roles';

    // Define the primary key (optional if the primary key is 'id')
    protected $primaryKey = 'id';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
    ];

    // Define the relationship with the User model
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
