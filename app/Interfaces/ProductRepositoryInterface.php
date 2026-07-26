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
    
    public function getById(
        string $id
    );

    public function getBySlug(
        string $slug
    );

    public function create(
        array $data
    );
}