<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
         $products = Cache::remember($cacheKey, 60, function () use ($request) {
            return QueryBuilder::for(Product::class)
                ->allowedFilters(['name', 'id', 'description', 'image'])
                ->allowedSorts(['name', 'id', 'price'])
                ->defaultSort('price')
                ->paginate()
                ->appends($request->query());
        });
    
        return response()->json(['products' => $products], 200);
    } 
    public function store(Request $request): JsonResponse {
         
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description'=>'string',
            'price'=>'required',
            'image' => 'image|max:2048', 
            'category_id' => 'required|exists:categories,id', 
        ]);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }
    
        $product = Product::create($validatedData);
        return response()->json(['product' => $product], 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string',
            'price' => 'required',
            'category_id' => 'required|exists:categories,id', 
            'image' => 'image|max:2048', 
    ]);
    $product = Product::find($id);
    if (!$product) 
    {
        return response()->json(['message' => 'product not found'], 404);
    }
    
    $product->name = $validatedData['name'];
    $product->description = $validatedData['description'];
    $product->price = $validatedData['price'];
    $product->category_id = $validatedData['category_id'];
    if ($request->hasFile('image')) 
    {
        // Delete the previous image (if it exists)
        Storage::disk('public')->delete($product->image);

        $imagePath = $request->file('image')->store('products', 'public');
        $validatedData['image'] = $imagePath;
    }

    $product->update($validatedData);

    $product->save();
    return response()->json(['message' => 'product updated successfully'], 200);
}
    
public function show($id){
    $product=Product::find($id);
    if (!$product) {
        return response()->json(['error' => 'product not found.'], 404);
    }
    return response()->json(['message' => 'product show  successfully.'], 200);
}
     public function destroy($id)
{
    $product= Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'product not found.'], 404);
    }
    $product->delete();

    return response()->json(['message' => 'product deleted successfully.'], 200);

}
}
