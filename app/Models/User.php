<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Department;
use App\Models\CourseEnrollment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'auth_id',
        'image',
        'system_ip',
        'status',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Override Method
    public function sendPasswordResetNotification($token)
    {
        $url = "https://localhost:3000/reset-password?token=".$token;
        $this->notify(new ResetPasswordNotification($url));
    }
    public function loginDetails()
    {
        return $this->hasMany(AuthCheck::class, 'login_id','login_id');
    }
}
