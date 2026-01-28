<?php

namespace App\Models;
use App\Models\invoices;
use App\Models\invoice_attachments;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'id_Invoice',
        'invoice_number',
        'id_product',
        'product',
        'quantity',
        'price',
        'tax_rate',
        'description',
        'Section',
        'Status',
        'Value_Status',
        'Payment_Date',
        'note',
        'user'
    ];
    
    public function invoices()
    {
        return $this->belongsTo(invoices::class, 'id_Invoice');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'id_product');
    }
}
