<?php

namespace Tests\Feature;

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
            ->assertJsonValidationErrors(['product_id', 'quantity']);

        $errors = $response->json('errors');

        $this->assertEquals('The product id field is required.', $errors['product_id'][0]);
        $this->assertEquals('The quantity field is required.', $errors['quantity'][0]);
    }

    /**
     * Test the product calculation part
     *
     * @return void
     */
    public function testProductCalculation(): void
    {
        $randomNumber = rand(1, 5);
        $discount = rand(10, 30);
        $product = Product::create([
            'name' => 'A',
            'price' => '50',
        ]);

        $totalPrice = ($product->price * $randomNumber) - $discount;
        $product
            ->promotion()
            ->create([
                'quantity' => $randomNumber,
                'total' => $totalPrice,
            ]);

        $response = $this->postJson(
            '/api/products/calculate',
            [
                'product_id' => $product->id,
                'quantity' => $randomNumber
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'total_price' => $totalPrice,
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
            ->assertJsonValidationErrors(['products']);

        $errors = $response->json('errors')['products'];
        $this->assertEquals('The products field is required.', $errors[0]);

        // Test with products empty array
        $response = $this->postJson(
            '/api/products/place-order',
            [
                'products' => ['test']
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);

        $errors = $response->json('errors');

        foreach ($errors as $key => $error) {
            $this->assertEquals("The $key field is required.", $error[0]);
        }

        // Test with wrong types
        $response = $this->postJson(
            '/api/products/place-order',
            [
                'products' => [
                    [
                        'product_id' => 'test',
                        'quantity' => 'test',
                    ],
                ],
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);

        $errors = $response->json('errors');
        foreach ($errors as $key => $error) {
            $this->assertEquals("The $key field must be an integer.", $error[0]);
        }

        // Test with wrong product ID
        $response = $this->postJson(
            '/api/products/place-order',
            [
                'products' => [
                    [
                        'product_id' => rand(1000, 5000),
                        'quantity' => rand(1, 5),
                    ],
                ],
            ],
            $this->getHeaders()
        );

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);

        $errors = $response->json('errors');
        foreach ($errors as $key => $error) {
            $this->assertEquals("The selected $key is invalid.", $error[0]);
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
                'products' => [
                    [
                        'product_id' => $productId,
                        'quantity' => rand(1, 5),
                    ],
                    [
                        'product_id' => $secondProductId,
                        'quantity' => rand(1, 5),
                    ],
                ],
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
