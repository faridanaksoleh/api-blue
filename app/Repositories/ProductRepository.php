<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Isset_;

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
        })->with('productImages');

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

    public function getById(
        string $id
    ) {
        $query = Product::where('id', $id)->with('productImages');
        
        return $query->first();
    }

    public function getBySlug(
        string $slug
    ) {
        $query = Product::where('slug', $slug)->with('productImages');
        
        return $query->first();
    }

    public function create(
        array $data
    ) {
        DB::beginTransaction();
        try {
            $product = new Product;
            $product->store_id = $data['store_id'];
            $product->product_category_id = $data['product_category_id'];
            $product->name = $data['name'];
            $product->slug = Str::slug($data['name']) . '-i' . rand(100000, 999999) . '.' . rand(100000, 999999);
            $product->description = $data['description'];
            $product->condition = $data['condition'];
            $product->price = $data['price'];
            $product->weight = $data['weight'];
            $product->stock = $data['stock'];
            $product->save();


            $prdouctImageRepository = new ProductImageRepository();
            
            if (isset($data['product_images'])) {
                foreach ($data['product_images'] as $productImage) {
                    $prdouctImageRepository->create([
                        'product_id' => $product->id,
                        'image' => $productImage['image'],
                        'is_thumbnail' => $productImage['is_thumbnail']
                    ]);
                }
            }

            DB::commit();

            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}