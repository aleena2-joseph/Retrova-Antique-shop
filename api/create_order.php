<?php
require_once __DIR__ . '/../functions.php';
requireLogin();

$amount = (int)(Cart::total() * 100);
if ($amount <= 0) { 
    http_response_code(400); 
    echo json_encode(['error' => 'Empty cart']); 
    exit; 
}

$data = PaymentService::createRazorpayOrder($amount);
if (!$data) { 
    http_response_code(500); 
    echo json_encode(['error' => 'Razorpay error']); 
    exit; 
}

Order::create(User::id(), $data['id'], $amount);

header('Content-Type: application/json');
echo json_encode($data);
