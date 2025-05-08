<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchProductRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $productsData = $this->productService->searchProducts($validatedData);
            
            return (new ProductCollection($productsData))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
                
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve products',
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
    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $product = $this->productService->createProduct($validatedData);

            return response()->json([
                'message' => 'Product created successfully',
                'product' => new ProductResource($product)
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
            $product = $this->productService->getProductById($id);
            return new ProductResource($product);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found',
                'errors' => [
                    'id' => ['The requested product does not exist']
                ]
            ], Response::HTTP_NOT_FOUND); 
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $product = $this->productService->updateProduct($id, $validatedData);
            
            return new ProductResource($product); 
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found',
                'errors' => ['id' => ['The requested product does not exist']]
            ], Response::HTTP_NOT_FOUND); 
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update product',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $result = $this->productService->deleteProduct($id);
            return response()->json($result, Response::HTTP_OK);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found',
                'errors' => ['id' => ['The specified product does not exist']]
            ], Response::HTTP_NOT_FOUND);
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
