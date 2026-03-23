<?php
// app/Imports/ProductsImport.php
namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public int $skipped  = 0;
    public array $errors = [];

    /**
     * Accepted column headers (case-insensitive, spaces become underscores):
     *   name          — required
     *   price_tall    — required (also accepted: price, price_tall)
     *   category      — optional (also accepted: category_id)
     *   description   — optional
     *   size          — optional (Tall / Grande / Both)
     *   price_grande  — optional
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // +2 because row 1 is heading

            try {
                // Normalize all keys: lowercase, spaces→underscore, trim
                $data = [];
                foreach ($row->toArray() as $key => $value) {
                    $normalKey = strtolower(trim(str_replace([' ', '-'], '_', $key)));
                    $data[$normalKey] = $value;
                }

                // Skip if entirely empty
                $allEmpty = collect($data)->filter(fn($v) => !is_null($v) && $v !== '')->isEmpty();
                if ($allEmpty) continue;

                // ── name ─────────────────────────────────────────────
                $name = trim($data['name'] ?? '');
                if (empty($name)) {
                    $this->errors[] = "Row {$rowNum}: skipped — 'name' column is empty.";
                    $this->skipped++;
                    continue;
                }

                // ── price_tall ───────────────────────────────────────
                $priceTall = $data['price_tall']
                    ?? $data['price']
                    ?? $data['tall_price']
                    ?? null;

                if (is_null($priceTall) || !is_numeric($priceTall)) {
                    $this->errors[] = "Row {$rowNum}: skipped — 'price_tall' is missing or not a number (value: '{$priceTall}').";
                    $this->skipped++;
                    continue;
                }

                // ── category ─────────────────────────────────────────
                $catVal = $data['category'] ?? $data['category_id'] ?? null;

                if (empty($catVal)) {
                    $category = Category::first()
                        ?? Category::create(['name' => 'General']);
                } elseif (is_numeric($catVal)) {
                    $category = Category::find((int) $catVal)
                        ?? Category::firstOrCreate(['name' => 'General']);
                } else {
                    $category = Category::firstOrCreate([
                        'name' => ucfirst(strtolower(trim($catVal)))
                    ]);
                }

                // ── price_grande ─────────────────────────────────────
                $priceGrande = $data['price_grande']
                    ?? $data['grande_price']
                    ?? null;

                // ── size ─────────────────────────────────────────────
                $sizeRaw   = trim($data['size'] ?? 'Both');
                $sizeMap   = ['tall' => 'Tall (16oz)', 'grande' => 'Grande (22oz)', 'both' => 'Both'];
                $sizeClean = $sizeMap[strtolower($sizeRaw)] ?? 'Both';

                // ── Create product ────────────────────────────────────
                Product::create([
                    'name'         => $name,
                    'description'  => $data['description'] ?? null,
                    'category_id'  => $category->id,
                    'size'         => $sizeClean,
                    'price_tall'   => (float) $priceTall,
                    'price_grande' => ($priceGrande && is_numeric($priceGrande))
                                        ? (float) $priceGrande
                                        : null,
                    'is_available' => true,
                    'main_photo'   => null,
                ]);

                $this->imported++;

            } catch (\Exception $e) {
                $this->errors[] = "Row {$rowNum}: error — " . $e->getMessage();
                $this->skipped++;
            }
        }
    }
}