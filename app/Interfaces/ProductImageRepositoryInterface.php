<?php

namespace App\Interfaces;

interface ProductImageRepositoryInterface
{
    public function create(
        array $data
    );

    public function deleteByProductId(
        string $id
    );
}