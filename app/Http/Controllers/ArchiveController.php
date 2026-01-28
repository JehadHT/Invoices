<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();

        return view('Invoices.Archive', compact('invoices'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice = invoices::withTrashed()->where('id', $request->invoice_id)->first();
        $attachments = invoice_attachments::where('invoice_id', $request->invoice_id)->get();

        if ($request->type == 'delete') {
            if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
            }
        }
        $invoice->forceDelete();
        session()->flash('delete_invoice');
        }else {
            $invoice->restore();
            session()->flash('restore_invoice');
        }
        return redirect('/Archive');
    }
}
