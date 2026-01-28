<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return invoices::all();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'Invoice Number',
            'Invoice Date',
            'Due Date',
            'Section ID',
            'Amount',
            'Discount',
            'Tax',
            'Total',
            'Status',
            'Notes',
            'Created At',
            'Updated At',
        ];
    }
}
