<?php
// app/Models/OrderItem.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class OrderItem extends Model
{
    protected $fillable = [
        'transaction_id', 'product_id', 'product_name',
        'size', 'unit_price', 'quantity', 'subtotal',
    ];
 
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
 
    public function addons()
    {
        return $this->hasMany(OrderItemAddon::class);
    }
}
