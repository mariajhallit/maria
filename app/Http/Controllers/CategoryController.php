<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;






class CategoryController extends Controller
{
    //
   public function index(Request $request): JsonResponse
{
    $categories = Category::with(['products' => function ($query) {
        $query->select('id', 'name', 'description', 'image', 'price');
    }])
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
            'id'=>'required',
           
        ]);
        $category = Category::create($validatedData);
        return response()->json(['category' => $category], 201);
}
    public function update(Request $request, $id){
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
       
    ]);
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'Cat not found'], 404);
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
public function importCategories(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:xlsx,csv', // Validate file type (Excel or CSV)
    ]);

    $file = $request->file('csv_file');

    Excel::import(new CategoryImport, $file);

    return response()->json(['message' => 'Categories imported successfully'], 200);
}
public function exportCategories()
    {
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

}