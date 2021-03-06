<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'created_by',
        'system_ip',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id','name');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id')->select('id','name');
    }
}
