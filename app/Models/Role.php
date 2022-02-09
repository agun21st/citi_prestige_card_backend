<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'auth_id')->select('id', 'name', 'login_id', 'email', 'auth_id', 'image', 'status');
    }
}
