<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'brand_id',
        'slug'
    ];

    public function favorite(): HasMany 
    {
        return $this->hasMany(Favorite::class);
    }

    public function productVariant(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productImage(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function attributeValue(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
