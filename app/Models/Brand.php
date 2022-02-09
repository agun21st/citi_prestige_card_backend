<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $fillable = [
        'name',
        'category_id',
        'created_by',
        'system_ip',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id','name');
    }
}
