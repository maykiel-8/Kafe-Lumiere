<?php
// app/Models/Product.php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Uncomment after installing Laravel Scout:
// use Laravel\Scout\Searchable;
 
class Product extends Model
{
    use SoftDeletes;
    // use Searchable;
 
    protected $fillable = [
        'name', 'description', 'category_id', 'size',
        'price_tall', 'price_grande', 'main_photo', 'is_available',
    ];
 
    protected $casts = [
        'is_available'  => 'boolean',
        'price_tall'    => 'decimal:2',
        'price_grande'  => 'decimal:2',
    ];
 
    // ── Relationships ────────────────────────────────────────
 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
 
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
 
    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'product_addon');
    }
 
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    // ── Accessors ────────────────────────────────────────────
 
    public function getAvgRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
 
    public function getMainPhotoUrlAttribute(): string
    {
        return $this->main_photo
            ? asset('storage/' . $this->main_photo)
            : asset('images/placeholder.png');
    }
 
    // ── Laravel Scout: searchable fields ─────────────────────
 
    public function toSearchableArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'category'    => $this->category->name ?? '',
        ];
    }
}
