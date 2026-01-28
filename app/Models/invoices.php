<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function section()
    {
        return $this->belongsTo(section::class, 'section_id');
    }

    public function details()
    {
        return $this->hasMany(invoices_details::class, 'id_Invoice');
    }

    public function attachments()
    {
        return $this->hasMany(invoice_attachments::class, 'invoice_id');
    }
}
