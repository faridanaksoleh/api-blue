<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use UUID;

    protected $fillable = [
        'parent_id',
        'image',
        'name',
        'slug',
        'tagline',
        'description',
    ];

    public function parent()
    {
        return $this->belongTo(ProductCategory::class, 'parent_id', 'id');
    } 
    
    public function childrens()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }
}
