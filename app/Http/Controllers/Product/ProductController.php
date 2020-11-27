<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Category;

class ProductController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.product.productList', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categoryArr = Category::where('status',1)->orderBy('name','asc')->pluck('name', 'id')->toArray();
        $categoryList = ['0' => __('lang.SELECT_CATEGORY_OPT')] + $categoryArr;
        return view('admin.product.productCreate')->with(compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'category_id' => 'required|not_in:0',
            'unit' => 'required',
        ]);

        $productCode = "P-".date('my') . substr(uniqid(), 9, 12);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->unit = $request->unit;
        $product->product_code = $productCode;
        $product->created_at = date('Y-m-d H:s:i');
        $product->updated_at = date('Y-m-d H:s:i');
        $product->save();
        return Redirect()->route('productList')->with('status', 'Product Created Successfullly!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $product = Product::findOrFail($id);
        $catArr = Category::where('status',1)->orderBy('name','asc')->pluck('name', 'id')->toArray();
        $catList = ['0' => __('lang.SELECT_CATEGORY_OPT')] + $catArr;
        return view('admin.product.productEdit', compact('product','catList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $validatedData = $request->validate([
            'product_name' => 'required|max:255|unique:products,product_name,' . $product->id,
            'category_id' => 'required|not_in:0',
            'unit' => 'required',
        ]);

        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->unit = $request->unit;
        $product->updated_at = date('Y-m-d H:s:i');
        $product->save();
        return Redirect()->route('productList')->with('status', 'Product Updated Successfullly!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return Redirect()->route('productList')->with('status', 'Product Deleted Successfullly!');
    }

}
