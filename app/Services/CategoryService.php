<?php 

namespace App\Services;

use App\Models\Category;
use DB;
use Exception;

class CategoryService {
    public function createCategory(array $categoryData){
        return DB::transaction(function () use ($categoryData) {
            return Category::create($categoryData);
        });
    }
}