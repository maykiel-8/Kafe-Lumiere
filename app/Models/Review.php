<?php
// app/Models/Review.php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Review extends Model
{
    use SoftDeletes;
 
    protected $fillable = [
        'user_id', 'product_id', 'transaction_id', 'rating', 'comment',
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
 
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
