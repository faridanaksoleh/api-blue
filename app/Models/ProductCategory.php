<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Jangan lupa import ini

class ProductCategory extends Model
{
    use HasFactory; 
    // HAPUS "use UUID;" biar tidak bentrok/bingung. Kita manual saja.

    // ==========================================
    // POIN 1: MEMAKSA LARAVEL TAHU INI BUKAN ANGKA
    // ==========================================
    public $incrementing = false; // Matikan auto-increment
    protected $keyType = 'string'; // Beritahu ID adalah string/text

    // ==========================================
    // POIN 2: GENERATE UUID SAAT CREATING
    // ==========================================
    protected static function booted()
    {
        static::creating(function ($model) {
            // Jika ID kosong, isikan dengan UUID baru
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'parent_id',
        'image',
        'name',
        'slug',
        'tagline',
        'description',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'. $search . '%');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    } 
    
    public function children() // Saya ubah jadi children (bukan childrens) biar grammarnya pas
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}