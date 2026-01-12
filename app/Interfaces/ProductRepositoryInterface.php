<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?string $productCategoryId,
        ?int $limit,
        bool $execute
    );

    public function getAllPaginated(
        ?string $search,
        ?string $productCategoryId = null,
        ?int $rowPerPage,
    );
}