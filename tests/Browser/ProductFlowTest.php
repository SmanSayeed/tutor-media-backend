<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductFlowTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A test for viewing a product and adding it to the cart.
     *
     * @return void
     */
    public function test_can_view_product_and_add_to_cart()
    {
        // Create a user and a product
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $product) {
            // Login, visit products page, and click on a product
            $browser->loginAs($user)
                ->visit('/products')
                ->assertSee($product->name)
                ->clickLink($product->name)
                ->assertPathIs('/product/' . $product->slug);

            // On product page, add to cart
            $browser->assertSee($product->name)
                ->press('Add to Cart')
                ->assertSee('Product added to cart successfully');

            // Visit cart and verify
            $browser->visit('/cart')
                ->assertSee($product->name);
        });
    }
}