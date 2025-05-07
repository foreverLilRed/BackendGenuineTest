<?php

namespace App\Services;

use App\Models\Category;
use Arr;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{

    public function searchCategories(array $filters = [])
    {
        return DB::transaction(function () use ($filters) {
            $query = Category::query();

            if (Arr::has($filters, 'name')) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            }

            if (Arr::has($filters, 'description')) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            }

            $perPage = Arr::get($filters, 'per_page', 10);

            return $query->paginate($perPage)
                ->appends($filters);
        });
    }
    public function createCategory(array $categoryData)
    {
        return DB::transaction(function () use ($categoryData) {
            return Category::create($categoryData);
        });
    }

    public function getCategoryById($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                throw new ModelNotFoundException("Category not found with id: {$id}");
            }

            return $category;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateCategory($id, array $data)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($id);

            if (!$category) {
                throw new ModelNotFoundException("Category not found with id: {$id}");
            }

            $category->update($data);
            DB::commit();

            return $category->fresh(); 

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteCategory($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($id);

            if (!$category) {
                throw new ModelNotFoundException("Category not found with id: {$id}");
            }

            $category->delete();
            DB::commit();

            return ['message' => 'Category deleted successfully'];

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}