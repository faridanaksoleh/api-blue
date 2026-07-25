<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use UUID, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

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
        return $this->belongsTo(ProductCategory::class);
    }

    public function productImages()
    {
        return $this->hasMany(productImage::class);
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
