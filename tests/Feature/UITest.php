<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('header displays correctly on all pages', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('SSB Leather')
             ->assertSee('backdrop-blur-md')
             ->assertSee('sticky top-0')
             ->assertSee('cart-count');
});

test('header search functionality is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Search for products')
             ->assertSee('type="search"', false)
             ->assertSee('toggleSearch()');
});

test('header mobile navigation works', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('nav-toggle')
             ->assertSee('openNavDrawer()')
             ->assertSee('lg:hidden');
});

test('footer displays correctly', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('©')
             ->assertSee('SSB Leather')
             ->assertSee('support@ssbleather.com')
             ->assertSee('09610‑957957');
});

test('footer has proper social links', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('aria-label="facebook"', false)
             ->assertSee('aria-label="instagram"', false)
             ->assertSee('aria-label="twitter"', false);
});

test('responsive design classes are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('max-w-7xl')
             ->assertSee('mx-auto')
             ->assertSee('px-4')
             ->assertSee('sm:px-6')
             ->assertSee('lg:px-8');
});

test('tailwind CSS is loaded', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('tailwindcss', false);
});

test('proper meta tags are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('<meta name="viewport"', false)
             ->assertSee('<meta name="csrf-token"', false)
             ->assertSee('charset="utf-8"', false);
});

test('accessibility attributes are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('aria-label=')
             ->assertSee('role=');
});

test('hero slider has proper navigation', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('goToSlide')
             ->assertSee('prevSlide')
             ->assertSee('nextSlide');
});

test('product cards have proper structure', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => true,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('card')
             ->assertSee('hover:shadow-xl')
             ->assertSee('transition-all');
});

test('buttons have proper styling and interactions', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('hover:bg-')
             ->assertSee('transition-colors')
             ->assertSee('duration-200');
});

test('loading states and animations are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('animate-spin')
             ->assertSee('transition-all')
             ->assertSee('duration-300');
});

test('color scheme is consistent', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('bg-red-600')
             ->assertSee('text-red-600')
             ->assertSee('hover:bg-red-700');
});

test('typography is consistent', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('font-bold')
             ->assertSee('font-semibold')
             ->assertSee('text-lg')
             ->assertSee('text-xl');
});

test('spacing and layout are consistent', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('py-8')
             ->assertSee('px-4')
             ->assertSee('mb-6')
             ->assertSee('gap-6');
});

test('mobile-first responsive design', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('sm:')
             ->assertSee('md:')
             ->assertSee('lg:')
             ->assertSee('xl:');
});

test('dark mode support classes are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('dark:');
});

test('focus states for accessibility', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('focus:')
             ->assertSee('focus:ring-')
             ->assertSee('focus:outline-none');
});

test('hover effects are smooth', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('hover:scale-')
             ->assertSee('transform')
             ->assertSee('transition-transform');
});

test('loading animations are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('animate-pulse')
             ->assertSee('animate-bounce');
});

test('notification system works', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('showNotification')
             ->assertSee('fixed top-4 right-4');
});

test('modal and drawer components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('fixed inset-0')
             ->assertSee('z-50')
             ->assertSee('backdrop-blur');
});

test('form styling is consistent', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('border border-gray-300')
             ->assertSee('rounded-lg')
             ->assertSee('focus:ring-2');
});

test('badge and status indicators are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('bg-red-500')
             ->assertSee('text-white')
             ->assertSee('rounded-full');
});

test('pagination styling is present', function () {
    $response = $this->get(route('products.index'));

    $response->assertStatus(200)
             ->assertSee('pagination')
             ->assertSee('justify-center');
});

test('empty state designs are present', function () {
    $response = $this->get(route('cart.index'));

    $response->assertStatus(200)
             ->assertSee('Your cart is empty')
             ->assertSee('w-24 h-24')
             ->assertSee('text-center');
});

test('error state styling is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('text-red-600')
             ->assertSee('border-red-500');
});

test('success state styling is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('text-green-600')
             ->assertSee('bg-green-500');
});

test('warning state styling is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('text-yellow-600')
             ->assertSee('bg-yellow-500');
});

test('info state styling is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('text-blue-600')
             ->assertSee('bg-blue-500');
});

test('cross-browser compatibility classes', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('-webkit-')
             ->assertSee('-moz-')
             ->assertSee('-ms-');
});

test('print styles are considered', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('print:');
});

test('reduced motion support', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('motion-reduce:');
});

test('high contrast mode support', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('contrast-more:');
});

test('prefers-color-scheme support', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('dark:');
});

test('performance optimizations are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('loading="lazy"')
             ->assertSee('decoding="async"');
});

test('semantic HTML structure', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('<header')
             ->assertSee('<main')
             ->assertSee('<footer')
             ->assertSee('<section')
             ->assertSee('<article');
});

test('proper heading hierarchy', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('<h1')
             ->assertSee('<h2')
             ->assertSee('<h3');
});

test('alt text for images', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('alt=');
});

test('proper form labels', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('<label')
             ->assertSee('for=');
});

test('keyboard navigation support', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('tabindex=')
             ->assertSee('focus:');
});

test('screen reader support', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('sr-only')
             ->assertSee('aria-');
});

test('skip links for accessibility', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('skip to main content');
});

test('language and direction support', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('lang=')
             ->assertSee('dir=');
});

test('timezone and locale handling', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Asia/Dhaka')
             ->assertSee('৳');
});

test('currency formatting is consistent', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('৳')
             ->assertSee('number_format');
});

test('date and time formatting', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('now()')
             ->assertSee('format(');
});

test('error handling UI is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('try')
             ->assertSee('catch')
             ->assertSee('error');
});

test('loading states are handled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('loading')
             ->assertSee('spinner')
             ->assertSee('skeleton');
});

test('offline support indicators', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('navigator.onLine')
             ->assertSee('offline');
});

test('progress indicators are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('progress')
             ->assertSee('step')
             ->assertSee('current');
});

test('breadcrumb navigation is styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('breadcrumb')
             ->assertSee('flex items-center');
});

test('tab navigation is styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('tab')
             ->assertSee('active');
});

test('accordion components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('accordion')
             ->assertSee('collapse');
});

test('carousel/slider components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('carousel')
             ->assertSee('slide');
});

test('tooltip components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('tooltip')
             ->assertSee('hover');
});

test('dropdown components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('dropdown')
             ->assertSee('menu');
});

test('modal components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('modal')
             ->assertSee('dialog');
});

test('toast notifications are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('toast')
             ->assertSee('notification');
});

test('alert components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('alert')
             ->assertSee('warning');
});

test('badge components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('badge')
             ->assertSee('pill');
});

test('avatar components are styled', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('avatar')
             ->assertSee('rounded-full');
});

test('button variants are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('btn-primary')
             ->assertSee('btn-secondary')
             ->assertSee('btn-success')
             ->assertSee('btn-danger')
             ->assertSee('btn-warning')
             ->assertSee('btn-info')
             ->assertSee('btn-light')
             ->assertSee('btn-dark');
});

test('input field variants are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('form-control')
             ->assertSee('form-select')
             ->assertSee('form-check')
             ->assertSee('form-range');
});

test('table styling is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('table')
             ->assertSee('thead')
             ->assertSee('tbody')
             ->assertSee('tr')
             ->assertSee('th')
             ->assertSee('td');
});

test('card component variations', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('card')
             ->assertSee('card-header')
             ->assertSee('card-body')
             ->assertSee('card-footer')
             ->assertSee('card-title')
             ->assertSee('card-text');
});

test('jumbotron/hero section styling', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('jumbotron')
             ->assertSee('hero')
             ->assertSee('display-4');
});

test('navbar component variations', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('navbar')
             ->assertSee('navbar-brand')
             ->assertSee('navbar-nav')
             ->assertSee('navbar-toggler');
});

test('list group components', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('list-group')
             ->assertSee('list-group-item');
});

test('media object components', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('media')
             ->assertSee('media-body');
});

test('embed components for videos', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('embed-responsive')
             ->assertSee('ratio');
});

test('utilities classes are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('d-none')
             ->assertSee('d-block')
             ->assertSee('d-inline')
             ->assertSee('d-flex')
             ->assertSee('justify-content-')
             ->assertSee('align-items-')
             ->assertSee('text-')
             ->assertSee('bg-')
             ->assertSee('p-')
             ->assertSee('m-')
             ->assertSee('border')
             ->assertSee('rounded')
             ->assertSee('shadow');
});

test('grid system is properly implemented', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('container')
             ->assertSee('row')
             ->assertSee('col')
             ->assertSee('col-md-')
             ->assertSee('col-lg-')
             ->assertSee('offset-');
});

test('flexbox utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('d-flex')
             ->assertSee('flex-column')
             ->assertSee('flex-row')
             ->assertSee('justify-content-')
             ->assertSee('align-items-')
             ->assertSee('flex-wrap');
});

test('spacing utilities are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('p-')
             ->assertSee('m-')
             ->assertSee('mt-')
             ->assertSee('mb-')
             ->assertSee('ml-')
             ->assertSee('mr-')
             ->assertSee('px-')
             ->assertSee('py-');
});

test('color utilities are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('text-primary')
             ->assertSee('text-secondary')
             ->assertSee('text-success')
             ->assertSee('text-danger')
             ->assertSee('text-warning')
             ->assertSee('text-info')
             ->assertSee('text-light')
             ->assertSee('text-dark')
             ->assertSee('bg-primary')
             ->assertSee('bg-secondary')
             ->assertSee('bg-success')
             ->assertSee('bg-danger')
             ->assertSee('bg-warning')
             ->assertSee('bg-info')
             ->assertSee('bg-light')
             ->assertSee('bg-dark');
});

test('border utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('border')
             ->assertSee('border-top')
             ->assertSee('border-bottom')
             ->assertSee('border-left')
             ->assertSee('border-right')
             ->assertSee('border-0')
             ->assertSee('rounded')
             ->assertSee('rounded-circle')
             ->assertSee('rounded-pill');
});

test('shadow utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('shadow')
             ->assertSee('shadow-sm')
             ->assertSee('shadow-lg')
             ->assertSee('shadow-none');
});

test('position utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('position-static')
             ->assertSee('position-relative')
             ->assertSee('position-absolute')
             ->assertSee('position-fixed')
             ->assertSee('position-sticky');
});

test('display utilities are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('d-none')
             ->assertSee('d-block')
             ->assertSee('d-inline')
             ->assertSee('d-inline-block')
             ->assertSee('d-flex')
             ->assertSee('d-inline-flex')
             ->assertSee('d-grid');
});

test('float utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('float-left')
             ->assertSee('float-right')
             ->assertSee('float-none');
});

test('overflow utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('overflow-auto')
             ->assertSee('overflow-hidden')
             ->assertSee('overflow-scroll')
             ->assertSee('overflow-visible');
});

test('visibility utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('visible')
             ->assertSee('invisible');
});

test('image utilities are present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('img-fluid')
             ->assertSee('img-thumbnail');
});

test('text utilities are comprehensive', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('text-left')
             ->assertSee('text-center')
             ->assertSee('text-right')
             ->assertSee('text-justify')
             ->assertSee('text-lowercase')
             ->assertSee('text-uppercase')
             ->assertSee('text-capitalize')
             ->assertSee('font-weight-')
             ->assertSee('font-italic')
             ->assertSee('text-decoration-')
             ->assertSee('text-truncate');
});

test('vertical alignment utilities', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('align-baseline')
             ->assertSee('align-top')
             ->assertSee('align-middle')
             ->assertSee('align-bottom')
             ->assertSee('align-text-top')
             ->assertSee('align-text-bottom');
});

test('close button styling', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('close')
             ->assertSee('btn-close');
});

test('spinner/loading indicators', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('spinner')
             ->assertSee('spinner-border')
             ->assertSee('spinner-grow');
});

test('ratio utilities for responsive embeds', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('ratio')
             ->assertSee('ratio-16x9')
             ->assertSee('ratio-4x3')
             ->assertSee('ratio-1x1');
});

test('stretched link utilities', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('stretched-link');
});

test('visually hidden utilities', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('visually-hidden')
             ->assertSee('visually-hidden-focusable');
});

test('screen reader utilities', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('sr-only')
             ->assertSee('sr-only-focusable');
});
