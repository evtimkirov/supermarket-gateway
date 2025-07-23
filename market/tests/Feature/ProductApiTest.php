<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Promotion;
use Tests\TestCase;
use App\Models\Product;

/**
 * Test the product API endpoints
 */
class ProductApiTest extends TestCase
{
    /**
     * Test the API connection without API token
     *
     * @return void
     */
    public function testApiConnection()
    {
        $response = $this->postJson('/api/products/calculate');
        $response->assertStatus(401);

        $response = $this->postJson('/api/products/place-order');
        $response->assertStatus(401);
    }

    /**
     * Test the product calculation API endpoint with wrong parameters
     *
     * @return void
     */
    public function testProductCalculationWithWrongParams(): void
    {
        $response = $this->postJson(
            '/api/products/calculate',
            [],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['sku_string']);

        $errors = $response->json('errors');

        $this->assertEquals('The sku string field is required.', $errors['sku_string'][0]);
    }

    /**
     * Test the product calculation part
     *
     * @return void
     */
    public function testProductCalculation(): void
    {
        $product = Product::whereName(fake()->randomElement(['A', 'B']))->first();

        $response = $this->postJson(
            '/api/products/calculate',
            [
                'sku_string' => str_repeat($product->name, $product->promotion->quantity),
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'total_price' => $product->promotion->total,
            ]);
    }

    /**
     * Test the place order API endpoint with wrong parameters
     *
     * @return void
     */
    public function testPlaceOrderWithWrongParams(): void
    {
        // Test without any data
        $response = $this->postJson(
            '/api/products/place-order',
            [],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['sku_string']);

        $errors = $response->json('errors')['sku_string'];
        $this->assertEquals('The sku string field is required.', $errors[0]);

        // Test with products empty array
        $response = $this->postJson(
            '/api/products/place-order',
            [
                'The sku string field is required.' => '',
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);

        $errors = $response->json('errors');

        foreach ($errors as $error) {
            $this->assertEquals('The sku string field is required.', $error[0]);
        }

        // Test with wrong types
        $response = $this->postJson(
            '/api/products/place-order',
            [
                'sku_string' => fake()->numberBetween(1, 5),
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);

        $errors = $response->json('errors');
        foreach ($errors as $error) {
            $this->assertEquals('The sku string field format is invalid.', $error[0]);
        }
    }

    /**
     * Test the place order API endpoint
     *
     * @return void
     */
    public function testPlaceOrder(): void
    {
        $productId = Product::factory()->create()->id;
        $secondProductId = Product::factory()->create()->id;

        $response = $this->postJson(
            '/api/products/place-order',
            [
                'sku_string' => fake()->randomElement(['ABDAA', 'AAABBBCCC', 'ABCCDAA', 'CDCABDAA']),
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'The order has been placed.',
            ]);
    }
}
