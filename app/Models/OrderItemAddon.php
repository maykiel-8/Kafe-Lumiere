<?php
// app/Models/OrderItemAddon.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class OrderItemAddon extends Model
{
    protected $fillable = ['order_item_id', 'addon_name', 'addon_price'];
}
