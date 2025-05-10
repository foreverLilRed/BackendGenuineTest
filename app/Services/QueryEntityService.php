<?php 

namespace App\Services;

use Illuminate\Http\Request;

class QueryEntityService {
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService){
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function handleQueryEntity($request)
    {
        $type = strtolower($request->input('queryResult.parameters.EntityType', ''));

        if ($type === 'category') {
            return $this->getCategories($request);
        } elseif ($type === 'product') {
            return $this->getProducts($request);
        } else {
            return 'I did not understand if you meant categories or products.';
        }
    }

    public function getCategories(Request $request)
    {
        $filters = [
            'name' => $request->input('queryResult.parameters.product_name', ''),
            'description' => $request->input('queryResult.parameters.product_description', ''),
        ];

        $categories = $this->categoryService->searchCategories($filters);

        if ($categories->isEmpty()) {
            return 'No categories found.';
        }

        $categoriesNames = $categories->pluck('name')->toArray();
        return 'The available categories are: ' . implode(', ', $categoriesNames);
    }

    private function getProducts(Request $request)
    {
        $filters = [
            'name' => $request->input('queryResult.parameters.product_name', ''),
            'description' => $request->input('queryResult.parameters.product_description', ''),
        ];

        $products = $this->productService->searchProducts($filters);

        if ($products->isEmpty()) {
            return 'No products found.';
        }

        $productNames = $products->pluck('name')->toArray();
        return 'The available products are: ' . implode(', ', $productNames);
    }
}