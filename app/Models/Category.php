<?php

namespace App\Models;

use App\Models\Tool;
use App\Models\Course;
use App\Models\Department;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'created_by',
        'status',
        'system_ip',
    ];
}
