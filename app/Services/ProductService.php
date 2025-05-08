<?php

namespace App\Services;

use App\Models\Product;
use Arr;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{

    public function searchProducts(array $filters = [])
    {
        //Quito la transaccion debido a que solo usare selects y uso el with para un Eager Loading
        $query = Product::with('category'); 

        if (Arr::has($filters, 'name')) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (Arr::has($filters, 'description')) {
            $query->where('description', 'like', '%' . $filters['description'] . '%');
        }

        if (Arr::has($filters, 'min_quantity')) {
            $query->where('quantity', '>', $filters['min_quantity']);
        }

        if (Arr::has($filters, 'max_quantity')) {
            $query->where('quantity', '<', $filters['max_quantity']);
        }

        if (Arr::has($filters, 'category_name')) {
            $query->whereHas('category', function ($categoryQuery) use ($filters) {
                $categoryQuery->where('name', 'like', '%' . $filters['category_name'] . '%');
            });
        }

        if (Arr::has($filters, 'category_id')) {
            $query->whereHas('category', function ($categoryQuery) use ($filters) {
                $categoryQuery->where('id', $filters['category_id']);
            });
        }

        $perPage = Arr::get($filters, 'per_page', 10);

        return $query->paginate($perPage)
            ->appends($filters);
    }

    public function createProduct(array $productData)
    {
        return DB::transaction(function () use ($productData) {
            return Product::create($productData);
        });
    }

    public function getProductById($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                throw new ModelNotFoundException("Product not found with id: {$id}");
            }

            return $product;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateProduct($id, array $data)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);

            if (!$product) {
                throw new ModelNotFoundException("Product not found with id: {$id}");
            }

            $product->update($data);
            DB::commit();

            return $product->fresh(); 

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);

            if (!$product) {
                throw new ModelNotFoundException("Product not found with id: {$id}");
            }

            $product->delete();
            DB::commit();

            return ['message' => 'Product deleted successfully'];

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}