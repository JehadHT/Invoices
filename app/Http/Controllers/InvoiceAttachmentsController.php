<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_file=$request->validate([
            'file_name' => 'mimes:pdf,jpeg,png,jpg|max:2048',
        ],[
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون pdf, jpeg , png , jpg',
            'file_name.max' => 'حجم المرفق لا يجب ان يتعدى 2 ميجا',
        ]);
        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();
        $invoice_number = $request->invoice_number;
        $invoice_id = $request->invoice_id; 
        $attachments = new invoice_attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $invoice_number;
        $attachments->invoice_id = $invoice_id; 
        $attachments->Created_by = Auth::user()->name;
        $file->move(public_path('Attachments/'. $invoice_number), $file_name);
        $attachments->save();

        session()->flash('ADD', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice_attachments $invoice_attachments)
    {
        //
    }
}
