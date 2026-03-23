<?php
// database/seeders/AddonSeeder.php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Addon;
 
class AddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            ['name' => 'Pearls',      'price' => 15],
            ['name' => 'Pudding',     'price' => 20],
            ['name' => 'Cheese Foam', 'price' => 25],
            ['name' => 'Nata de Coco','price' => 15],
            ['name' => 'Grass Jelly', 'price' => 15],
        ];
        foreach ($addons as $a) {
            Addon::create($a);
        }
    }
}
