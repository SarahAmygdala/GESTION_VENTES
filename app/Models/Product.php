<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'cost',
        'stock',
        'min_stock',
        'barcode',
        'image',
        'active'
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'cost'     => 'decimal:2',
        'active'   => 'boolean',
        'stock'    => 'integer',
        'min_stock' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . Str::random(5);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) return 'rupture';
        if ($this->stock <= $this->min_stock) return 'faible';
        return 'ok';
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }
}
