<?php
// database/seeders/ReviewSeeder.php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
 
class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users        = User::where('role', 'cashier')->get();
        $transactions = Transaction::with('orderItems')->where('status', 'completed')->take(15)->get();
 
        $comments = [
            'Absolutely love it! The pearls are perfectly chewy.',
            'Great taste, slightly sweet for me but still good.',
            'So refreshing! My new favorite drink.',
            'Good but could use a bit more flavor.',
            'Premium taste, worth every peso!',
            'The cheese foam is a game changer.',
            'Consistent quality every visit.',
            'Best milk tea in the area!',
        ];
 
        foreach ($transactions->take(10) as $trans) {
            $product = $trans->orderItems->first()->product ?? null;
            if (!$product) continue;
            $user = $users->random();
 
            Review::firstOrCreate(
                ['user_id' => $user->id, 'product_id' => $product->id, 'transaction_id' => $trans->id],
                [
                    'rating'  => rand(3, 5),
                    'comment' => $comments[array_rand($comments)],
                ]
            );
        }
    }
}
