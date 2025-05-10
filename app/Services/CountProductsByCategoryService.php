<?php 

namespace App\Services;

use App\Models\Category;

class CountProductsByCategoryService{
    public function handleCountProductsByCategory($request)
    {
        $category_name = strtolower($request->input('queryResult.parameters.category_name', ''));

        if (empty($category_name)) {
            return "Please provide a valid category name.";
        }

        $category = Category::whereRaw('LOWER(name) = ?', [$category_name])->first();

        if (!$category) {
            return "The category '{$category_name}' was not found.";
        }

        $totalQuantity = $category->products()->sum('quantity');

        return "There are a total of {$totalQuantity} products available in the '{$category->name}' category.";
    }
}