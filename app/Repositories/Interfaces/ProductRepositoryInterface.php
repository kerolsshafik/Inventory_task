<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function findById(string $id): ?Product;

    public function create(array $data): Product;

    public function update(string $id, array $data): Product;

    public function delete(string $id): bool;
}
