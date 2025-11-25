<?php

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create an order', function () {
    $customer = Customer::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'subtotal' => 100.00,
        'tax_amount' => 0.00, // No tax
        'shipping_amount' => 5.00,
        'total_amount' => 105.00,
        'status' => 'pending',
        'payment_status' => 'pending',
        'billing_address' => ['address' => '123 Main St'],
        'shipping_address' => ['address' => '123 Main St'],
    ]);

    expect($order)->toBeInstanceOf(Order::class)
        ->and($order->total_amount)->toBe('105.00')
        ->and($order->status)->toBe('pending');
});

test('order number is auto-generated', function () {
    $customer = Customer::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'subtotal' => 100.00,
        'total_amount' => 100.00,
        'billing_address' => ['address' => '123 Main St'],
        'shipping_address' => ['address' => '123 Main St'],
    ]);

    expect($order->order_number)->toStartWith('ORD-')
        ->and($order->order_number)->not->toBeEmpty();
});

test('order can check if paid', function () {
    $customer = Customer::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'subtotal' => 100.00,
        'total_amount' => 100.00,
        'payment_status' => 'paid',
        'billing_address' => ['address' => '123 Main St'],
        'shipping_address' => ['address' => '123 Main St'],
    ]);

    expect($order->isPaid())->toBeTrue();
});

test('order can check if can be cancelled', function () {
    $customer = Customer::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'subtotal' => 100.00,
        'total_amount' => 100.00,
        'status' => 'pending',
        'billing_address' => ['address' => '123 Main St'],
        'shipping_address' => ['address' => '123 Main St'],
    ]);

    expect($order->canBeCancelled())->toBeTrue();
});

test('order has customer relationship', function () {
    $customer = Customer::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'subtotal' => 100.00,
        'total_amount' => 100.00,
        'billing_address' => ['address' => '123 Main St'],
        'shipping_address' => ['address' => '123 Main St'],
    ]);

    expect($order->customer)->toBeInstanceOf(Customer::class)
        ->and($order->customer->email)->toBe('john@example.com');
});


