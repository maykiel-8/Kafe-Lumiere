<?php
// app/Models/ProductPhoto.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class ProductPhoto extends Model
{
    protected $fillable = ['product_id', 'path', 'is_main'];
 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
 
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
