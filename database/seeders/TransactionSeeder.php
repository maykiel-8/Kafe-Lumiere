<?php
// database/seeders/TransactionSeeder.php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
 
class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $cashier  = User::where('role', 'cashier')->first();
        $products = Product::all();
 
        for ($i = 1; $i <= 30; $i++) {
            $orderProducts = $products->random(rand(1, 3));
            $subtotal = 0;
            $orderItems = [];
 
            foreach ($orderProducts as $prod) {
                $qty      = rand(1, 3);
                $price    = $prod->price_tall;
                $lineTotal = $price * $qty;
                $subtotal += $lineTotal;
                $orderItems[] = [
                    'product_id'   => $prod->id,
                    'product_name' => $prod->name,
                    'size'         => 'Tall (16oz)',
                    'unit_price'   => $price,
                    'quantity'     => $qty,
                    'subtotal'     => $lineTotal,
                ];
            }
 
            $tax   = round($subtotal * 0.12, 2);
            $total = $subtotal + $tax;
 
            $transaction = Transaction::create([
                'order_number'    => 'ORD-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'cashier_id'      => $cashier->id,
                'customer_name'   => fake()->randomElement(['Walk-in', fake()->name(), fake()->name()]),
                'payment_method'  => fake()->randomElement(['cash', 'gcash', 'maya', 'card']),
                'subtotal'        => $subtotal,
                'tax'             => $tax,
                'total'           => $total,
                'amount_tendered' => $total + rand(0, 50),
                'change'          => rand(0, 50),
                'status'          => fake()->randomElement(['completed', 'completed', 'completed', 'pending', 'cancelled']),
                'created_at'      => now()->subDays(rand(0, 90)),
            ]);
 
            foreach ($orderItems as $item) {
                $transaction->orderItems()->create($item);
            }
        }
    }
}
