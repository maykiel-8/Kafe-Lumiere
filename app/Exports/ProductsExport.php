<?php
// app/Exports/ProductsExport.php
namespace App\Exports;
 
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Product::with(['category', 'addons'])->withTrashed()->get();
    }
 
    public function headings(): array
    {
        return ['ID', 'Name', 'Category', 'Size', 'Price (Tall)', 'Price (Grande)', 'Add-ons', 'Available', 'Deleted'];
    }
 
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category->name ?? '',
            $product->size,
            $product->price_tall,
            $product->price_grande ?? '',
            $product->addons->pluck('name')->join(', '),
            $product->is_available ? 'Yes' : 'No',
            $product->deleted_at ? 'Yes' : 'No',
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4A2C17']], 'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]],
        ];
    }
}
