<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        $categories = QueryBuilder::for(Category::class)
        ->allowedFilters(['name', 'id'])
        ->allowedSorts(['name', 'id', 'created_at'])
        ->defaultSort('id') 
        ->paginate()
        ->appends(request()->query());
    
        return response()->json(['categories' => $categories], 200);
    } 
    
     public function store(Request $request): JsonResponse {
         
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'id'=>'required |unique',
        ]);
        $category = Category::create($validatedData);
        return response()->json(['categories' => $categories], 201);
}
    public function update(Request $request, $id){
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'id'=>'required |unique',
    ]);
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }
    $category->name = $validatedData['name'];

    $category->save();
    return response()->json(['message' => 'Category updated successfully'], 200);
}
    public function show($id){
    $category=Category::find($id);
    if (!$category) {
        return response()->json(['error' => 'category not found.'], 404);
    }
    return response()->json(['message' => 'category show  successfully.'], 200);
}
     public function destroy($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['error' => 'categoryr not found.'], 404);
    }
    $category->delete();

    return response()->json(['message' => 'category deleted successfully.'], 200);

}
}