<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\section;
use App\Models\products;
use App\Models\invoices;
use App\Models\invoices_details;
use Carbon\Carbon;

class InvoicesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء 3 أقسام
        $sections = [
            [
                'section_name' => 'الأجهزة الكهربائية',
                'description' => 'قسم الأجهزة الكهربائية والإلكترونيات',
                'Created_by' => 'admin'
            ],
            [
                'section_name' => 'الملابس والأقمشة',
                'description' => 'قسم الملابس والأقمشة والمنسوجات',
                'Created_by' => 'admin'
            ],
            [
                'section_name' => 'الأثاث والديكور',
                'description' => 'قسم الأثاث والديكور المنزلي',
                'Created_by' => 'admin'
            ]
        ];

        $createdSections = [];
        foreach ($sections as $sectionData) {
            $createdSections[] = section::create($sectionData);
        }

        // إنشاء منتجين لكل قسم
        $productNames = [
            'الأجهزة الكهربائية' => [
                'غسالة ملابس',
                'ثلاجة ذكية'
            ],
            'الملابس والأقمشة' => [
                'قميص قطني',
                'جينز عالي الجودة'
            ],
            'الأثاث والديكور' => [
                'طاولة صالة خشبية',
                'كرسي مريح جلدي'
            ]
        ];

        $createdProducts = [];
        foreach ($createdSections as $section) {
            $sectionProducts = $productNames[$section->section_name] ?? [];
            $createdProducts[$section->id] = [];
            foreach ($sectionProducts as $productName) {
                $product = products::create([
                    'product_name' => $productName,
                    'description' => 'منتج من ' . $section->section_name,
                    'section_id' => $section->id
                ]);
                $createdProducts[$section->id][] = $product;
            }
        }

        // إنشاء 10 فواتير بحالات مختلفة
        $statuses = [
            ['status_name' => 'مدفوعة', 'status_value' => 1],
            ['status_name' => 'مدفوعة جزئيا', 'status_value' => 3],
            ['status_name' => 'غير مدفوعة', 'status_value' => 2],
        ];

        $invoiceCount = 0;
        $statusIndex = 0;

        for ($i = 1; $i <= 10; $i++) {
            $section = $createdSections[$i % 3];
            $products = $createdProducts[$section->id];
            $product = $products[($i - 1) % count($products)];

            // توزيع الفواتير على الحالات الأربع (3 مدفوعة، 2 جزئية، 3 غير مدفوعة)
            if ($i <= 3) {
                $status = $statuses[0]; // مدفوعة
            } elseif ($i <= 5) {
                $status = $statuses[1]; // مدفوعة جزئيا
            } else {
                $status = $statuses[2]; // غير مدفوعة
            } 

            $invoiceDate = Carbon::now()->subDays(rand(1, 30));
            $dueDate = $invoiceDate->copy()->addDays(30);
            
            // الحسابات
            $amount = rand(1000, 10000);
            $discount = rand(0, 500);
            $vat_rate = 15;
            $amount_after_discount = $amount - $discount;
            $value_vat = ($amount_after_discount * $vat_rate) / 100;
            $total = $amount_after_discount + $value_vat;

            // تحديد المبلغ المجموع بناءً على الحالة
            if ($status['status_value'] == 1) { // مدفوعة
                $amount_collection = $total;
                $payment_date = $dueDate->copy()->addDays(rand(0, 5));
            } elseif ($status['status_value'] == 2) { // مدفوعة جزئيا
                $amount_collection = round($total * 0.5, 2); // 50% من المبلغ
                $payment_date = $dueDate->copy()->addDays(rand(0, 5));
            } else { // غير مدفوعة أو مؤرشفة
                $amount_collection = 0;
                $payment_date = null;
            }

            $invoice = invoices::create([
                'invoice_number' => 'INV-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'invoice_Date' => $invoiceDate->format('Y-m-d'),
                'Due_date' => $dueDate->format('Y-m-d'),
                'product' => $product->product_name,
                'section_id' => $section->id,
                'Amount_collection' => $amount_collection,
                'Amount_Commission' => $amount,
                'Discount' => $discount,
                'Value_VAT' => $value_vat,
                'Rate_VAT' => $vat_rate,
                'Total' => $total,
                'Status' => $status['status_name'],
                'Value_Status' => $status['status_value'],
                'note' => 'فاتورة رقم ' . $i,
                'Payment_Date' => $payment_date ? $payment_date->format('Y-m-d') : null,
            ]);

            // إنشاء تفاصيل الفاتورة
            invoices_details::create([
                'id_Invoice' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'product' => $product->product_name,
                'Section' => $section->section_name,
                'Status' => $status['status_name'],
                'Value_Status' => $status['status_value'],
                'Payment_Date' => $payment_date ? $payment_date->format('Y-m-d') : null,
                'note' => 'تفاصيل فاتورة رقم ' . $i,
                'user' => 'admin'
            ]);
        }

        // $this->command->info('تم إنشاء:');
        // $this->command->info('- 3 أقسام');
        // $this->command->info('- 6 منتجات (منتجان لكل قسم)');
        // $this->command->info('- 10 فواتير بحالات مختلفة:');
        // $this->command->info('  * 3 فواتير مدفوعة');
        // $this->command->info('  * 2 فاتورة مدفوعة جزئيا');
        // $this->command->info('  * 3 فواتير غير مدفوعة');
        // $this->command->info('  * 2 فاتورة مؤرشفة');
    }
}
