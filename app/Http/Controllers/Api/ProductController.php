<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $categoryId = $request->input('category_id');
        // $products = Product::when(
        //     $categoryId,
        //     fn ($query, $categoryId) => $query->categoryId($categoryId)
        // )->paginate();
        // return ProductResource::collection($products);
        $categoryId = $request->input('category_id');
        $UserId = $request->input('user_id');
        $products = Product::where('category_id','LIKE','%'. $categoryId . '%')
            ->where('user_id','LIKE','%'. $UserId . '%')->paginate()->load('category','user');
        return ProductResource::collection($products);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create([
            ...$request->validate([
                'name' => 'required|string|max:20',
                'description' => 'required|string',
                'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'image_url' => 'required',
                'category_id' => 'required',
            ]),
            'user_id' => 1,
        ]);
        dd($product);

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return response()->json($product, 200);
        $product = Product::find($id);
        $product->load('user','category');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update(
            $request->validate([
                'name' => 'required|string|max:20',
                'description' => 'required|string',
                'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'image_url' => 'required',
                'category_id' => 'required',
            ])
        );
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response(status:204);
    }
}
