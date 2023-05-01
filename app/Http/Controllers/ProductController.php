<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @group Products
 *
 * APIs for managing Products
 *
 * @header Content-Type application/json
 * @authenticated
 */
class ProductController extends Controller
{
    /**
     * Get All Products
     *
     * This endpoint is used to fetch all products available in the database.
     *
     * @queryParam page int The page number from pagination. Defaut is '1' Example: 1
     *
     * @response scenario="Get All Products"{
     *"data": [
     *    {
     *    "id": 1,
     *        "productName": "quo",
     *        "productPrice": "$15",
     *        "discountedPrice": "$13.5",
     *        "discount": "$1.5",
     *        "productDescription": "Ut rerum aut deleniti eveniet ad et ullam perferendis."
     *    },
     *    {
     *        "id": 2,
     *        "productName": "Laptop",
     *        "productPrice": "$500",
     *        "discountedPrice": "$450",
     *        "discount": "$50",
     *        "productDescription": "This is a brand new laptop"
     *    }
     *  ]
     *}
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
     * Add Products to the Database
     *
     * This endpoint is used to add a product to the database.
     *
     * @bodyParam name string required Example: Laptop
     * @bodyParam price double required Example: 199
     * @bodyParam description string required
     *
     *@response 201 scenario="Add a Product"{
     * "data": {
     *   "id": 2,
     *   "productName": "veritatis",
     *   "productPrice": "$30",
     *   "discountedPrice": "$27",
     *   "discount": "$3",
     *   "productDescription": "Esse cupiditate eaque qui laboriosam quis id."
     * }
     *}
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
     * Get a Single Product
     *
     * This endpoint is used to return a single products from the database.
     *
     * @urlParam id integer required The ID of the product.
     *
     * @response scenario="Get a Single Product"{
     * "data": {
     *   "id": 2,
     *   "productName": "veritatis",
     *   "productPrice": "$30",
     *   "discountedPrice": "$27",
     *   "discount": "$3",
     *   "productDescription": "Esse cupiditate eaque qui laboriosam quis id."
     * }
     *}
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
