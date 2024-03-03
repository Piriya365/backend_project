<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('admin')->except(['index','showMore']);
    }
    /**
     * Display a listing of the resource.
     */
    public function showMore($id)
    {
        $product = Product::find($id);
        return view('products.more')->with('products', $product);
    }


    public function index()
    {
        $product = Product::all();
        return view('products.index')->with('products', $product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = Storage::disk('public')->put('images', $request->image);

        $prepare = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'image' => $file,
        ];

        $product = Product::create($prepare);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(request $request, Product $product)
    {
        $prepare = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ];

        if ($request->image) {
            $file = Storage::disk('public')->put('images', $request->image);
            $prepare['image'] = $file;
        }

        $productInst = Product::find($product->id);

        if ($productInst->image && $request->image) {
            unlink('storage/' . $productInst->image);
        }
        $productInst->update($prepare);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $productInst = Product::find($product->id);

        if ($productInst->image) {
            unlink('storage/' . $productInst->image);
        }

        $productInst->delete();

        return redirect()->route('products.index');
    }
}
