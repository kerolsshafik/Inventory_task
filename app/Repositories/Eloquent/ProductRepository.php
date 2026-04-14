<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->paginate($perPage);
    }

    public function findById(string $id): ?Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(string $id, array $data): Product
    {
        $product = $this->findById($id);
        $product->update($data);

        return $product->fresh();
    }

    public function delete(string $id): bool
    {
        return $this->findById($id)->delete();
    }
}
