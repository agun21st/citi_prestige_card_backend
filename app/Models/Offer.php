<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'offers';
    protected $fillable = [
        'title',
        'logo',
        'discount',
        'description',
        'category_id',
        'brand_id',
        'location_id',
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
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id')->select('id','name');
    }
}