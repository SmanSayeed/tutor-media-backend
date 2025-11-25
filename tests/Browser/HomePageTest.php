<?php

namespace Tests\Browser;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test that the homepage loads successfully with basic elements present.
     * This test verifies the core homepage functionality and presence of essential UI elements.
     *
     * @return void
     */
    public function testHomePageLoadsSuccessfully()
    {
        // Create test data
        $this->createTestData();

        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/')
                    ->assertTitle('User Panel')
                    ->assertSee('Welcome to our Shoe Store')
                    ->assertPresent('#slider-container')
                    ->assertPresent('#featured-products')
                    ->assertPresent('#new-arrivals')
                    ->assertPresent('#best-items')
                    ->assertPresent('#all-products')
                    ->assertPresent('#categories')
                    ->assertPresent('#reviews-viewport')
                    ->assertPresent('section.bg-white.border-y')
                    ->assertPresent('header')
                    ->assertPresent('footer');
        });
    }

    /**
     * Test the hero slider functionality including banner display and navigation.
     * Verifies that banners are displayed correctly and slider controls work.
     *
     * @return void
     */
    public function testHeroSliderFunctionality()
    {
        // Create banners for testing
        Banner::create([
            'title' => 'Summer Sale',
            'subtitle' => 'Up to 50% Off',
            'image_url' => '/images/banner/banner-1.png',
            'button_text' => 'Shop Now',
            'button_url' => '/products',
            'is_active' => true,
            'order' => 1
        ]);

        Banner::create([
            'title' => 'New Collection',
            'subtitle' => 'Latest Styles',
            'image_url' => '/images/banner/banner-2.png',
            'button_text' => 'Explore',
            'button_url' => '/categories',
            'is_active' => true,
            'order' => 2
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('#slider-container')
                    ->assertSee('Summer Sale')
                    ->assertSee('Up to 50% Off')
                    ->assertSee('Shop Now')
                    ->assertPresent('.absolute.bottom-4 button') // Slider indicators
                    ->assertPresent('button[aria-label="Next slide"]')
                    ->assertPresent('button[aria-label="Previous slide"]');

            // Test slider navigation
            $browser->click('button[aria-label="Next slide"]')
                    ->waitForText('New Collection')
                    ->assertSee('Latest Styles')
                    ->assertSee('Explore');
        });
    }

    /**
     * Test the featured products section display and functionality.
     * Verifies that featured products are shown with correct pricing and links.
     *
     * @return void
     */
    public function testFeaturedProductsSection()
    {
        // Create featured products
        $product = Product::create([
            'name' => 'Featured Sneakers',
            'slug' => 'featured-sneakers',
            'price' => 5000,
            'sale_price' => 4000,
            'is_active' => true,
            'is_featured' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 10
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                    ->assertPresent('#featured-products')
                    ->assertSee('Featured Products')
                    ->assertSee('Featured Sneakers')
                    ->assertSee('৳4,000') // Sale price
                    ->assertSee('৳5,000') // Original price with strikethrough
                    ->assertPresent('a[href="' . route('products.show', $product->slug) . '"]')
                    ->assertSee('View All');
        });
    }

    /**
     * Test the new arrivals section with product display and navigation.
     * Verifies that recently created products are displayed correctly.
     *
     * @return void
     */
    public function testNewArrivalsSection()
    {
        // Create new products (within 30 days)
        $newProduct = Product::create([
            'name' => 'New Running Shoes',
            'slug' => 'new-running-shoes',
            'price' => 6000,
            'is_active' => true,
            'main_image' => '/images/products/shoe-2.jpg',
            'stock_quantity' => 15,
            'created_at' => now()
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('#new-arrivals')
                    ->assertSee('New Products')
                    ->assertSee('New Running Shoes')
                    ->assertSee('৳6,000')
                    ->assertPresent('a[href="' . route('products.new-arrivals') . '"]')
                    ->assertSee('View All');
        });
    }

    /**
     * Test the best items/popular products section.
     * Verifies that products with high sales or view counts are displayed.
     *
     * @return void
     */
    public function testBestItemsSection()
    {
        // Create popular product
        $popularProduct = Product::create([
            'name' => 'Popular Casual Shoes',
            'slug' => 'popular-casual-shoes',
            'price' => 4500,
            'is_active' => true,
            'is_featured' => true,
            'sales_count' => 50,
            'view_count' => 200,
            'main_image' => '/images/products/shoe-3.jpg',
            'stock_quantity' => 20
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('#best-items')
                    ->assertSee('Popular Products')
                    ->assertSee('Popular Casual Shoes')
                    ->assertSee('৳4,500')
                    ->assertPresent('a[href="' . route('products.popular') . '"]')
                    ->assertSee('View All');
        });
    }

    /**
     * Test the all products section display.
     * Verifies that a selection of all active products is shown.
     *
     * @return void
     */
    public function testAllProductsSection()
    {
        // Create multiple products
        Product::create([
            'name' => 'All Products Item 1',
            'slug' => 'all-products-item-1',
            'price' => 3500,
            'is_active' => true,
            'main_image' => '/images/products/shoe-4.jpg',
            'stock_quantity' => 8
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('#all-products')
                    ->assertSee('All Products')
                    ->assertSee('All Products Item 1')
                    ->assertSee('৳3,500')
                    ->assertPresent('a[href="' . route('products.index') . '"]')
                    ->assertSee('View All');
        });
    }

    /**
     * Test the customer reviews section with slider functionality.
     * Verifies that reviews are displayed with ratings and customer information.
     *
     * @return void
     */
    public function testCustomerReviewsSection()
    {
        // Create test user and review
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false
        ]);

        $product = Product::create([
            'name' => 'Reviewed Product',
            'slug' => 'reviewed-product',
            'price' => 5000,
            'is_active' => true,
            'main_image' => '/images/products/shoe-5.jpg',
            'stock_quantity' => 5
        ]);

        Review::create([
            'customer_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Excellent quality and comfort!',
            'is_approved' => true
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('#reviews-viewport')
                    ->assertSee('Customer Reviews')
                    ->assertSee('John Doe')
                    ->assertSee('Reviewed Product')
                    ->assertSee('Excellent quality and comfort!')
                    ->assertPresent('#reviews-prev')
                    ->assertPresent('#reviews-next');
        });
    }

    /**
     * Test the categories section display.
     * Verifies that product categories are shown with proper navigation.
     *
     * @return void
     */
    public function testCategoriesSection()
    {
        // Create category
        $category = Category::create([
            'name' => 'Men\'s Shoes',
            'slug' => 'mens-shoes',
            'is_active' => true
        ]);

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/')
                    ->assertPresent('#categories')
                    ->assertSee('Men\'s Shoes')
                    ->assertPresent('a[href="' . route('categories.show', $category->slug) . '"]');
        });
    }

    /**
     * Test the brands section display.
     * Verifies that brand logos are displayed correctly.
     *
     * @return void
     */
    public function testBrandsSection()
    {
        // Create brand
        Brand::create([
            'name' => 'Nike',
            'slug' => 'nike',
            'logo' => '/images/brands/nike-logo.png',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('section.bg-white.border-y')
                    ->assertPresent('img[alt="Nike"]');
        });
    }

    /**
     * Test navigation elements and header functionality.
     * Verifies that main navigation links and search are present.
     *
     * @return void
     */
    public function testNavigationElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('nav')
                    ->assertPresent('a[href="' . route('home') . '"]')
                    ->assertPresent('a[href="' . route('products.index') . '"]')
                    ->assertPresent('a[href="' . route('categories.index') . '"]')
                    ->assertPresent('.relative input[type="search"]'); // Search input
        });
    }

    /**
     * Test responsive design elements across different screen sizes.
     * Verifies that the layout adapts correctly to mobile and desktop views.
     *
     * @return void
     */
    public function testResponsiveDesign()
    {
        $this->createTestData();

        $this->browse(function (Browser $browser) {
            // Test mobile view
            $browser->resize(375, 667) // iPhone SE size
                    ->visit('/')
                    ->assertPresent('.grid-cols-1') // Mobile grid for products
                    ->assertPresent('.text-center') // Centered text on mobile
                    ->assertMissing('.lg\\:grid-cols-12'); // Desktop grid classes should not apply

            // Test desktop view
            $browser->resize(1920, 1080) // Desktop size
                    ->visit('/')
                    ->assertPresent('.lg\\:grid-cols-12') // Desktop hero grid
                    ->assertPresent('.lg\\:col-span-9'); // Desktop hero content span
        });
    }

    /**
     * Test database state assertions to ensure data integrity.
     * Verifies that the homepage correctly reflects database state.
     *
     * @return void
     */
    public function testDatabaseStateAssertions()
    {
        // Create specific test data
        $activeProduct = Product::create([
            'name' => 'Active Product',
            'slug' => 'active-product',
            'price' => 3000,
            'is_active' => true,
            'main_image' => '/images/products/shoe-6.jpg',
            'stock_quantity' => 10
        ]);

        $inactiveProduct = Product::create([
            'name' => 'Inactive Product',
            'slug' => 'inactive-product',
            'price' => 2500,
            'is_active' => false,
            'main_image' => '/images/products/shoe-7.jpg',
            'stock_quantity' => 5
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Active Product')
                    ->assertDontSee('Inactive Product'); // Inactive products should not appear

            // Verify database state
            $this->assertDatabaseHas('products', [
                'name' => 'Active Product',
                'is_active' => true
            ]);

            $this->assertDatabaseHas('products', [
                'name' => 'Inactive Product',
                'is_active' => false
            ]);
        });
    }

    /**
     * Test edge cases including empty data scenarios.
     * Verifies graceful handling when no data is available.
     *
     * @return void
     */
    public function testEdgeCases()
    {
        // Test with no products
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('No New Arrivals')
                    ->assertSee('No Featured Products Available')
                    ->assertSee('No Best Items Available')
                    ->assertSee('No Products Available')
                    ->assertSee('No Reviews Yet')
                    ->assertSee('No Categories Available')
                    ->assertSee('No Brands Available');
        });

        // Test with only inactive banners
        Banner::create([
            'title' => 'Inactive Banner',
            'image_url' => '/images/banner/inactive.png',
            'is_active' => false,
            'order' => 1
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertDontSee('Inactive Banner')
                    ->assertSee('Welcome to Our Store'); // Fallback banner content
        });
    }

    /**
     * Helper method to create comprehensive test data for homepage testing.
     * Creates all necessary models with realistic data.
     *
     * @return void
     */
    private function createTestData()
    {
        // Create categories
        $category = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true
        ]);

        // Create brand
        $brand = Brand::create([
            'name' => 'Adidas',
            'slug' => 'adidas',
            'logo' => '/images/brands/adidas-logo.png',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Create products
        Product::create([
            'name' => 'Classic Sneakers',
            'slug' => 'classic-sneakers',
            'price' => 5000,
            'sale_price' => 4000,
            'is_active' => true,
            'is_featured' => true,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 20,
            'sales_count' => 15,
            'view_count' => 100,
            'description' => 'Comfortable classic sneakers for everyday wear.'
        ]);

        // Create banner
        Banner::create([
            'title' => 'Welcome to our Shoe Store',
            'subtitle' => 'Find your perfect pair',
            'image' => '/images/banner/banner-1.png',
            'button_text' => 'Shop Now',
            'button_url' => '/products',
            'is_active' => true,
            'order' => 1
        ]);
    }
}
