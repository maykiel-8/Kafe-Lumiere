<?php
// database/seeders/ProductSeeder.php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Addon;
 
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $classic  = Category::where('name', 'Classic')->first()->id;
        $fruit    = Category::where('name', 'Fruit Tea')->first()->id;
        $premium  = Category::where('name', 'Premium')->first()->id;
        $seasonal = Category::where('name', 'Seasonal')->first()->id;
 
        $addonMap = Addon::all()->pluck('id', 'name');
 
        $products = [
            ['name' => 'Brown Sugar Milk Tea', 'category_id' => $classic,  'price_tall' => 120, 'price_grande' => 140, 'description' => 'Rich brown sugar syrup with creamy milk tea base.',       'addons' => ['Pearls', 'Pudding']],
            ['name' => 'Taro Milk Tea',         'category_id' => $classic,  'price_tall' => 115, 'price_grande' => 135, 'description' => 'Smooth taro flavored milk tea.',                        'addons' => ['Pearls', 'Nata de Coco']],
            ['name' => 'Wintermelon Milk Tea',  'category_id' => $classic,  'price_tall' => 110, 'price_grande' => 130, 'description' => 'Traditional wintermelon sweetness.',                    'addons' => ['Pearls', 'Grass Jelly']],
            ['name' => 'Matcha Latte',          'category_id' => $premium,  'price_tall' => 145, 'price_grande' => 165, 'description' => 'Japanese matcha with steamed milk.',                    'addons' => ['Cheese Foam', 'Pudding']],
            ['name' => 'Salted Caramel Latte',  'category_id' => $premium,  'price_tall' => 155, 'price_grande' => 175, 'description' => 'Buttery caramel with salted cream.',                    'addons' => ['Cheese Foam']],
            ['name' => 'Strawberry Lychee',     'category_id' => $fruit,    'price_tall' => 130, 'price_grande' => 150, 'description' => 'Refreshing strawberry lychee blend.',                   'addons' => ['Pearls', 'Nata de Coco']],
            ['name' => 'Mango Pomelo Sago',     'category_id' => $fruit,    'price_tall' => 140, 'price_grande' => 160, 'description' => 'Summer-inspired mango fruit tea.',                      'addons' => ['Nata de Coco']],
            ['name' => 'Hokkaido Milk Tea',     'category_id' => $seasonal, 'price_tall' => 160, 'price_grande' => 180, 'description' => 'Creamy Hokkaido-style milk tea, limited season.',       'addons' => ['Pearls', 'Pudding']],
        ];
 
        foreach ($products as $data) {
            $addonIds = collect($data['addons'])->map(fn($n) => $addonMap[$n])->toArray();
            unset($data['addons']);
            $product = Product::create($data);
            $product->addons()->attach($addonIds);
        }
    }
}
