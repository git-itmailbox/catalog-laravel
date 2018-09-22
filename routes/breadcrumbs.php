<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > [Category]
Breadcrumbs::for('by_category', function ($trail, $category) {
//    dd($category);
    $trail->parent('home');
    $trail->push($category, route('by_category', $category));
});

// Home > Product
Breadcrumbs::for('show_product', function ($trail, $product) {
    $trail->parent('home');
    $trail->push($product->name, route('show_product', 'p'.$product->id));
});

// Admin Dashboard
Breadcrumbs::for('admin_dashboard', function ($trail) {
    $trail->push('Admin Panel', route('admin_dashboard'));
});

// Admin Dashboard > Manage Products
Breadcrumbs::for('admin.products', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push('Manage Products', route('admin.products'));
});

// Admin Dashboard > Manage Categories
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('admin_dashboard');
    $trail->push('Manage Categories', route('categories'));
});

// Admin Dashboard > Manage Products > view & edit product
Breadcrumbs::for('admin.product', function ($trail, $product) {
    $trail->parent('admin.products');
    $trail->push($product->name, route('admin.product', $product->id));
});

// Admin Dashboard > Manage Products > view & edit category
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push($category->name, route('category', $category->id));
});
