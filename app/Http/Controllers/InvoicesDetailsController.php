<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $inv= invoices::where('id', $id)->first();
        $invoices = invoices_details::where('id_Invoice', $id)->get();
        return view('Invoices.invoices_details', compact('invoices', 'inv'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function download($invoice_number, $file_name)
    {
        $file_path = $invoice_number . '/' . $file_name;
        
        if (!Storage::disk('public_uploads')->exists($file_path)) {
            abort(404, 'الملف غير موجود');
        }
        
        return response()->download(
            Storage::disk('public_uploads')->path($file_path)
        );
    }
    
    public function open_file($invoice_number, $file_name)
    {
        $file_path = $invoice_number . '/' . $file_name;
        
        if (!Storage::disk('public_uploads')->exists($file_path)) {
            abort(404, 'الملف غير موجود');
        }
        
        return response()->file(
            Storage::disk('public_uploads')->path($file_path)
        );
    }
    
}
