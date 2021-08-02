<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getAllProducts(){

        $products = Products::with(['section' => function($q){
            $q->select('id','section_name');
        }])->get();
        $sections = Sections::all();

       return view('products.allproducts',compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
       $product = Products::create([
            'product_name' => $request->product_name,
            'description' => $request->product_desc,
            'section_id' => $request->section_id,
        ]);
        return redirect()->back()->with(['success' => 'تم حفظ المنتج بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        $product = Products::find($product_id);
        $sections = Sections::all();
        if (!$product){
            return abort('404');
        }
        return view('products.editproduct',compact('product','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Products $products)
    {
        $product = $products::find($request->id);
        if(!$product){
            return redirect()->back();
        }
        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->product_desc,
            'section_id' => $request->section_id,
        ]);
        return redirect()->back()->with(['success' => 'تم تعديل المنتج بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $product = Products::find($product_id);
        if(!$product){
            return abort('404');
        }
        $product->delete();
        return redirect()->back()->with(['delete' => 'تم حذف المنتج بنجاح']);
    }
}
