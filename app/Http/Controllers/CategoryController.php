<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SearchCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchCategoryRequest $request){
        try {
            $validatedData = $request->validated();
            $categoryData = $this->categoryService->searchCategories($validatedData);
            
            return (new CategoryCollection($categoryData))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
                
        } catch (Exception $e) {
            
            return response()->json([
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $category = $this->categoryService->createCategory($validatedData);

            return response()->json([
                'message' => 'Category created successfully',
                'category' => $category
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return new CategoryResource($category);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found',
                'errors' => [
                    'id' => ['The requested category does not exist']
                ]
            ], Response::HTTP_NOT_FOUND); 
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $category = $this->categoryService->updateCategory($id, $validatedData);
            
            return new CategoryResource($category); // Laravel automáticamente usa HTTP 200
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found',
                'errors' => ['id' => ['The requested category does not exist']]
            ], Response::HTTP_NOT_FOUND); 
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update category',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try {
            $result = $this->categoryService->deleteCategory($id);
            return response()->json($result, Response::HTTP_OK);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found',
                'errors' => ['id' => ['The specified category does not exist']]
            ], Response::HTTP_NOT_FOUND);
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete category',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
