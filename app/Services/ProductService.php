<?php

namespace App\Services;

use App\Models\Product;
use DB;

class ProductService {
    public function createProduct(array $productData){
        return DB::transaction(function() use ($productData) {
            return Product::create($productData);
        });
    }
}