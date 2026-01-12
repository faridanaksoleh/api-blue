<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?string $productCategoryId,
        ?int $limit,
        bool $execute
    ) {
        $query = Product::where(function ($query) use ($search, $productCategoryId) {
            if($search) {
                $query->search($search);
            }

            if($productCategoryId) {
                $query->where('product_category_id', $productCategoryId);
            }
        });

        if($limit) {
            $query->take($limit);
        }

        if($execute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(
        ?string $search, 
        ?string $productCategoryId = null,
        ?int $rowPerPage,
    ) {
        $query = $this->getAll(
            $search, 
            $productCategoryId,
            null, 
            false
        );

        return $query->paginate($rowPerPage);
    }
}