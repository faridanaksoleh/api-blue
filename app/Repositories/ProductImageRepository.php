<?php

namespace App\Repositories;

use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    public function create(
        array $data
    ) {
        DB::beginTransaction();
        try {
            $productImage = new ProductImage();
            $productImage->product_id = $data['product_id'];
            $productImage->image = $data['image']->store('assets/products', 'public');
            $productImage->is_thumbnail = $data['is_thumbnail'];
            $productImage->save();
            
            DB::commit();
            return $productImage;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function deleteByProductId(
        string $id
    ) {
        DB::beginTransaction();
        try {
            $productImages = ProductImage::find($id);
            Storage::disk('public')->delete($productImages->image);
            $productImages->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}