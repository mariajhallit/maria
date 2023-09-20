<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        $products = QueryBuilder::for(Product::class)
        ->allowedFilters(['name', 'id','description','image'])
        ->allowedSorts(['name', 'id', 'price'])
        ->defaultSort('price') 
        ->paginate()
        ->appends(request()->query());
    
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
        $products = Category::create($validatedData);
        return response()->json(['products' => $products], 201);
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
        'description'=>'string',
        'price'=>'required ',
        'image'=>'max:255',
    ]);
    $products = Product::find($id);
    if (!$products) {
        return response()->json(['message' => 'product not found'], 404);
    }
    
    $products->name = $validatedData['name'];
    $products->description = $validatedData['description'];
    $products->price = $validatedData['price'];
    $products->image = $validatedData['image'];
    if ($request->hasFile('image')) {
        // Delete the previous image (if it exists)
        Storage::disk('public')->delete($product->image);

        $imagePath = $request->file('image')->store('products', 'public');
        $validatedData['image'] = $imagePath;
    }

    $product->update($validatedData);
    return response()->json(['message' => 'Product updated successfully'], 200);

    $products->save();
    return response()->json(['message' => 'product updated successfully'], 200);
}
    public function show($id){
    $products=Product::find($id);
    if (!$products) {
        return response()->json(['error' => 'product not found.'], 404);
    }
    return response()->json(['message' => 'product show  successfully.'], 200);
}
     public function destroy($id)
{
    $products = Product::find($id);

    if (!$products) {
        return response()->json(['error' => 'product not found.'], 404);
    }
    $products->delete();

    return response()->json(['message' => 'product deleted successfully.'], 200);

}
}
