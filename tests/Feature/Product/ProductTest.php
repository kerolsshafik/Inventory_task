<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class ProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clean up products table before each test
        Product::truncate();
        // Clear all caches
        Cache::flush();
    }

    /**
     * A basic test example.
     */
    public function test_can_create_product()
    {
        $sku = 'SKU-' . time() . '-' . rand(100, 999);
        $payload = [
            'sku' => $sku,
            'name' => 'Test Product',
            'price' => 100,
            'stock_quantity' => 20,
            'low_stock_threshold' => 5,
            'status' => 'active'
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'sku',
                    'name'
                ]
            ]);

        $this->assertDatabaseHas('products', [
            'sku' => $sku
        ]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Name',
            'price' => 200
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('products', [
            'id' => $product->id
        ]);
    }

    public function test_can_increment_stock()
    {
        $product = Product::factory()->create([
            'stock_quantity' => 10
        ]);

        $response = $this->postJson("/api/products/stock", [
            'id' => $product->id,
            'type' => 'increment',
            'quantity' => 5
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 15
        ]);
    }

    public function test_can_get_low_stock_products()
    {
        $lowStockProduct = Product::factory()->create([
            'name' => 'Low Stock Product',
            'stock_quantity' => 2,
            'low_stock_threshold' => 10
        ]);

        $normalStockProduct = Product::factory()->create([
            'name' => 'Normal Stock Product',
            'stock_quantity' => 50,
            'low_stock_threshold' => 10
        ]);

        $response = $this->getJson('/api/products/low-stock/list');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'stock_quantity',
                        'low_stock_threshold'
                    ]
                ]
            ]);

        // Verify the response contains only low stock products
        $data = $response->json('data');
        $this->assertCount(1, $data, 'Should return exactly 1 low stock product');
        $this->assertEquals($lowStockProduct->id, $data[0]['id']);
        $this->assertEquals('Low Stock Product', $data[0]['name']);
        $this->assertEquals(2, $data[0]['stock_quantity']);
    }
}
