<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\section;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        $products = products::all();
        return view('invoices.products', compact('sections', 'products' ));
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
        $valdation = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'section_id' => 'required',
        ],[
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
            'section_id.required' => 'يرجى اختيار القسم',
        ]);
        
        products::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);

        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
            return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = section::where('section_name', $request->section_name)->first()->id;
        
        $request->validate([
            'product_name' => 'required|max:255|unique:products,product_name,'.$request->product_id,
            ],[
                'product_name.required' => 'يرجى ادخال اسم المنتج',
                'product_name.unique' => 'اسم المنتج مسجل مسبقا',
            ]);    

        $products = products::findOrFail($request->product_id);
        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);
        session()->flash('edit', 'تم تعديل المنتج بنجاح ');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        products::findOrFail($request->product_id)->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح ');
        return redirect('/products');
    }
}
