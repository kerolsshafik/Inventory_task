<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\ApiResponse;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    use ApiResponse;
    public function __construct(
        private ProductService $productService
    ) {
    }

    public function index()
    {
        try {
            $perPage = request('per_page', 10);
            $products = $this->productService->getAll($perPage);
            // return ($products);
            return $this->paginatedResponse($products, );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getById($id);
            if (!$product) {
                return $this->notFoundResponse('Product not found');
            }
            return $this->successResponse($product);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->create($request->validated());
            return $this->successResponse($product, statusCode: 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 500);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = $this->productService->update($id, $request->validated());
            if (!$product) {
                return $this->notFoundResponse('Product not found');
            }
            return $this->successResponse($product);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Product not found');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->productService->delete($id);
            return $this->successResponse(['deleted' => true]);

        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Product not found');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 500);
        }
    }
    // adjustStock
    public function adjustStock(StockProductRequest $request)
    {
        $data = $request->validated();
        try {
            $product = $this->productService->adjustStock($data['id'], $data['type'], $data['quantity']);
            return $this->successResponse($product);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Product not found');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 400);
        }
    }
    // lowStock
    public function lowStock()
    {
        try {
            $products = $this->productService->getLowStock();
            return $this->successResponse($products);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Product not found');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), statusCode: 500);
        }
    }
}
