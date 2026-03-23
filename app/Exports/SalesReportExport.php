<?php
// app/Exports/SalesReportExport.php
namespace App\Exports;
 
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(
        private string $from,
        private string $to
    ) {}
 
    public function title(): string
    {
        return 'Sales ' . $this->from . ' to ' . $this->to;
    }
 
    public function collection()
    {
        return Transaction::with(['cashier', 'orderItems'])
            ->where('status', 'completed')
            ->whereBetween('created_at', [$this->from, $this->to . ' 23:59:59'])
            ->latest()
            ->get();
    }
 
    public function headings(): array
    {
        return ['Order #', 'Customer', 'Cashier', 'Items', 'Subtotal', 'Tax', 'Total', 'Payment', 'Date'];
    }
 
    public function map($t): array
    {
        return [
            $t->order_number,
            $t->customer_name,
            $t->cashier->full_name ?? '',
            $t->orderItems->count(),
            '₱' . number_format($t->subtotal, 2),
            '₱' . number_format($t->tax, 2),
            '₱' . number_format($t->total, 2),
            strtoupper($t->payment_method),
            $t->created_at->format('Y-m-d H:i'),
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4A2C17']]],
        ];
    }
}
