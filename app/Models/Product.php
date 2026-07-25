<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use UUID, HasFactory;

    // INI WAJIB ADA AGAR RELASI TIDAK NULL
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'description',
        'condition',
        'price',
        'weight',
        'stock'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'. $search . '%');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function productReview()
    {
        return $this->hasMany(ProductReview::class);
    }
}