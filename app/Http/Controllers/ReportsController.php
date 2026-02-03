<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Http\Request;
use App\Models\section;
use App\Models\invoices;
use App\Models\products;
class ReportsController extends Controller
{
    public function index()
    {
        $invoices = invoices::all();
        return view('reports.invoices_report');
    }

    public function customers()
    {
        $sections = section::all();
        return view('reports.customers_report', compact('sections'));
    }

    public function Search_invoices(Request $request)
    {

        $rdio = $request->rdio;

        // في حالة البحث بنوع الفاتورة
        if ($rdio == 1) {

            $request->validate([
                'type' => 'required|in:جميع الفواتير,مدفوعة,غير مدفوعة,مدفوعة جزئيا',
            ], [
                'type.required' => 'يرجى تحديد نوع الفواتير',
                'type.in' => 'نوع الفواتير غير صحيح',
            ]);

            $type = $request->type;

            // في حالة عدم تحديد تاريخ
            if ($request->start_at == '' && $request->end_at == '') {

                $search_by = 1;
                if ($type == 'جميع الفواتير') {
                    $invoices = invoices::select('*')->get();
                } else {
                    $invoices = invoices::select('*')->where('Status', '=', $type)->get();
                }
                return view('reports.invoices_report', compact('type', 'search_by'))->with('details', $invoices);
            }

            // في حالة تحديد تاريخ
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $search_by = 1;

            if ($type == 'جميع الفواتير') {
                $invoices = invoices::whereBetween('invoice_Date', [$start_at, $end_at])->get();
            } else {
                $invoices = invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $type)->get();
            }
            return view('reports.invoices_report', compact('type', 'start_at', 'end_at', 'search_by'))->with('details', $invoices);
        }

        // في البحث برقم الفاتورة
        if ($rdio == 2) {

            $request->validate([
                'invoice_number' => 'required',
            ], [
                'invoice_number.required' => 'يرجى إدخال رقم الفاتورة',
            ]);

            $invoice_number = $request->invoice_number;
            $search_by = 2;
            $invoices = invoices::select('*')->where('invoice_number', '=', $invoice_number)->get();
            return view('reports.invoices_report', compact('invoice_number', 'search_by'))->with('details', $invoices);
        }

        return redirect()->back()->with('error', 'يرجى اختيار خيار البحث');
    }

    public function Search_customers(Request $request)
    {
        $sections = section::all();
        $section_id = $request->Section ?: null;
        $product = $request->product ?? '';
        $start_at = $request->start_at ?? '';
        $end_at = $request->end_at ?? '';

        $sectionProducts = collect();
        if ($section_id) {
            $sectionProducts = products::where('section_id', $section_id)->pluck('product_name');
        }

        $query = invoices::query();

        if ($section_id) {
            $query->where('section_id', $section_id);
        }
        if ($product !== '') {
            $query->where('product', $product);
        }
        if ($start_at && $end_at) {
            $query->whereBetween('invoice_Date', [$start_at, $end_at]);
        }

        $details = $query->get();

        return view('reports.customers_report', compact('sections', 'details', 'section_id', 'product', 'start_at', 'end_at', 'sectionProducts'));
    }  
    // public function getproducts($id)
    // {
    //     $products = products::where('section_id', '=', $id)->pluck('product_name', 'id');
    //     return json_encode($products);
    // }
}
