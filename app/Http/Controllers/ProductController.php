<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        return ProductResource::collection(Product::all());
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
        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $productDescription = $request->input('description');

        $product = Product::create([
            'name' => $productName,
            'price' => $productPrice,
            'description' => $productDescription,
        ]);

        return response()->json([
            'data' => new ProductResource($product),
        ], 201);
    }

    /**
     * Display the specified resource.
     */

    public function show(Product $product)
    {
        //
        return new ProductResource($product);
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

    public function update(Request $request, Product $product)
    {
        //
        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $productDescription = $request->input('description');

        $data = [
            'name' => $productName,
            'price' => $productPrice,
            'description' => $productDescription,
        ];
        $product->update($data);

        return response()->json([
            'data' => new ProductResource($product),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Product $product)
    {
        //
        $product->delete();
        return response()->json([
            'message' => 'Product Deleted Successfully.'],
            204);
    }
}
