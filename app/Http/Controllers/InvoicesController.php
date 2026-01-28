<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\section;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        invoices::create(
            [
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product' => $request->product,
                'section_id' => $request->Section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
            ]
        );


        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move picture or file
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        $user = User::first();
        Notification::send($user, new AddInvoice($invoice_id));

        $user = User::get();
        $invoices = invoices::latest()->first();
        // Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

        // event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');

        return redirect('/invoices');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $invoice = invoices::where('id', $id)->first();
        $section = section::where('id', $invoice->section_id)->first();
        return view('invoices.status_update', compact('invoice', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = invoices::where('id', $id)->first();
        $sections = section::all();
        return view('invoices.edit_invoices', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices $invoices)
    {
        $invoices = invoices::findOrFail($request->invoice_id);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        $details = invoices_details::where('id_Invoice', $request->invoice_id);
        $details->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة : ' . "\" " . $request->invoice_number . " \"" . ' بنجاح');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::where('id', $id)->first();
        $attachments = invoice_attachments::where('invoice_id', $id)->get();
        if ($request->type == 'delete') {
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
                }
            }
            $invoice->forcedelete();

            session()->flash('delete_invoice');
        } else {
            $invoice->delete();
            session()->flash('Archive_invoice');
        }
        return redirect('/invoices');
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function status_update(Request $request, $id)
    {
        $invoice = invoices::findOrFail($id);
        if ($request->Status === 'مدفوعة') {
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->payment_Date,
            ]);
        } elseif ($request->Status === 'مدفوعة جزئيا') {
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->payment_Date,
            ]);
        } else {
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 2,
                'Payment_Date' => $request->payment_Date,
            ]);
        }
        invoices_details::create([
            'id_Invoice' => $id,
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product,
            'Section' => $invoice->section_id,
            'Status' => $request->Status,
            'Payment_Date' => $request->payment_Date,
            'Value_Status' => $invoice->Value_Status,
            'note' => $request->note ?? '-',
            'user' => (Auth::user()->name),
        ]);
        session()->flash('Change_Status', 'تم تعديل حالة الفاتورة بنجاح');
        return redirect('/invoices');
    }

    public function Paid_invoices()
    {
        $invoices = invoices::where('Value_Status', 1)->get();
        return view('Invoices.Paid_invoices', compact('invoices'));
    }
    public function unPaid_invoices()
    {
        $invoices = invoices::where('Value_Status', 2)->get();
        return view('invoices.unPaid_invoices', compact('invoices'));
    }

    public function Partially_invoices()
    {
        $invoices = invoices::where('Value_Status', 3)->get();
        return view('invoices.Partially_invoices', compact('invoices'));
    }

    public function print_invoice($id)
    {
        $invoice = invoices::where('id', $id)->first();
        $details = invoices_details::where('id_Invoice', $id)->get();
        $section = section::where('id', $invoice->section_id)->first();
        return view('invoices.print_invoice', compact('invoice', 'section','details'));
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'users.xlsx');
    }
}
