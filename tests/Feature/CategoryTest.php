<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a category', function () {
    $category = Category::create([
        'name' => 'Men Shoes',
        'slug' => 'men-shoes',
        'description' => 'All men shoes collection',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBe('Men Shoes')
        ->and($category->slug)->toBe('men-shoes')
        ->and($category->is_active)->toBeTrue();
});

test('category slug is auto-generated from name', function () {
    $category = Category::create([
        'name' => 'Women Shoes',
        'is_active' => true,
    ]);

    expect($category->slug)->toBe('women-shoes');
});

test('can get active categories', function () {
    Category::create(['name' => 'Active Category', 'is_active' => true]);
    Category::create(['name' => 'Inactive Category', 'is_active' => false]);

    $activeCategories = Category::active()->get();

    expect($activeCategories)->toHaveCount(1)
        ->and($activeCategories->first()->name)->toBe('Active Category');
});

test('category has subcategories relationship', function () {
    $category = Category::create(['name' => 'Test Category']);

    expect($category->subcategories())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('category has products relationship', function () {
    $category = Category::create(['name' => 'Test Category']);

    expect($category->products())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
});


