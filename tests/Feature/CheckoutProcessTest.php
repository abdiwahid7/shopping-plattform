<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutProcessTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_process_creates_order_and_clears_cart()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a product
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 10,
        ]);

        // Add product to session cart
        $this->withSession([
            'cart' => [
                $product->id => ['quantity' => 2],
            ],
        ]);

        // Prepare checkout data
        $checkoutData = [
            'billing_first_name' => 'John',
            'billing_last_name' => 'Doe',
            'billing_email' => 'john@example.com',
            'billing_phone' => '1234567890',
            'billing_address' => '123 Main St',
            'billing_city' => 'Cityville',
            'billing_state' => 'State',
            'billing_postal_code' => '12345',
            'billing_country' => 'Country',
            'payment_method' => 'cash_on_delivery',
        ];

        // Post to checkout process route
        $response = $this->post(route('checkout.process'), $checkoutData);

        // Assert redirect to success page
        $response->assertRedirect();

        // Assert order is created in database
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'billing_email' => 'john@example.com',
            'status' => 'pending',
        ]);

        // Assert order items created
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Assert product stock is decremented
        $this->assertEquals(8, $product->fresh()->stock);

        // Assert cart is cleared
        $this->assertEmpty(session('cart'));
    }
}
