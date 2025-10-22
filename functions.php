<?php
require_once __DIR__ . '/config.php';

// Backward compatibility wrappers - all delegate to OOP classes

function isLoggedIn() {
    return User::isLoggedIn();
}

function isAdmin() {
    return User::isAdmin();
}

function requireLogin() {
    AuthService::requireLogin();
}

function requireAdmin() {
    AuthService::requireAdmin();
}

function currentUserId() {
    return User::id();
}

function findCategories() {
    return Category::all();
}

function findProducts($q = '', $category = null) {
    return Product::search($q, $category);
}

function findProduct($id) {
    return Product::find($id);
}

function removeFromCart($productId) {
    Cart::remove($productId);
}

function syncSessionCartFromDB() {
    Cart::syncFromDatabase();
}

function clearCart() {
    Cart::clear();
}

function addToCart($productId, $qty = 1) {
    Cart::add($productId, $qty);
}

function updateCart($items) {
    Cart::update($items);
}

function cartItems() {
    return Cart::items();
}

function cartTotalAmount() {
    return Cart::total();
}

function formatINR($amount) {
    return Formatter::inr($amount);
}
