<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductService
{
    private string $cacheKey = 'products:list';

    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }
    public function getAll(int $perPage = 10)
    {
        $cacheKey = $this->cacheKey . ":page_" . request('page', 1);

        return Cache::remember($cacheKey, 60, function () use ($perPage) {
            return $this->productRepository->paginate($perPage);
        });
    }
    public function getById(string $id)
    {
        $cacheKey = "product:{$id}";

        return Cache::remember($cacheKey, 300, function () use ($id) {
            return $this->productRepository->findById($id);
        });
    }

    public function create(array $data)
    {
        $data['id'] = (string) Str::uuid();

        $product = $this->productRepository->create($data);

        $this->clearProductCache();


        return $product;
    }

    public function update(string $id, array $data)
    {
        $product = $this->productRepository->update($id, $data);

        Cache::forget("product:{$id}");
        $this->clearProductCache();

        return $product;
    }
    public function delete(string $id): bool
    {
        $result = $this->productRepository->delete($id);

        Cache::forget("product:{$id}");
        $this->clearProductCache();

        return $result;
    }
    public function adjustStock(string $id, string $type, int $quantity)
    {
        // dd($id, $type, $quantity);
        $product = $this->productRepository->findById($id);

        if ($type === 'increment') {
            $product->stock_quantity += $quantity;
        }

        if ($type === 'decrement') {
            if ($product->stock_quantity < $quantity) {
                throw new \Exception("Not enough stock available");
            }

            $product->stock_quantity -= $quantity;
        }

        $product->save();

        // clear caches
        Cache::forget("product:{$id}");
        $this->clearProductCache();

        return $product;
    }
    public function getLowStock()
    {
        return Cache::remember('products:low_stock', 120, function () {
            return $this->productRepository
                ->paginate(100)
                ->getCollection()
                ->filter(function ($product) {
                    return $product->stock_quantity < $product->low_stock_threshold;
                })
                ->values();
        });
    }
    private function clearProductCache(): void
    {
        Cache::forget('products:low_stock');

        // optional: flush pagination pages
        // Cache::flush(); ❌ (avoid in production)

        // better approach:
        for ($i = 1; $i <= 5; $i++) {
            Cache::forget("products:list:page_{$i}");
        }
    }

}
