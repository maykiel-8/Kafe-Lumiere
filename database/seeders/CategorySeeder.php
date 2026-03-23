<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Category;
 
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Classic', 'Fruit Tea', 'Premium', 'Seasonal'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
