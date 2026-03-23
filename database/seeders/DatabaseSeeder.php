<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Addon;
use App\Models\Transaction;
use App\Models\OrderItem;
use App\Models\Review;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            AddonSeeder::class,
            ProductSeeder::class,
            TransactionSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
