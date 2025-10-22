<?php
require_once __DIR__ . '/../functions.php';
requireLogin();

$input = json_decode(file_get_contents('php://input'), true);
$oid = $input['razorpay_order_id'] ?? '';
$pid = $input['razorpay_payment_id'] ?? '';
$sig = $input['razorpay_signature'] ?? '';

if (!$oid || !$pid || !$sig) { 
    http_response_code(400); 
    echo json_encode(['success' => false]); 
    exit; 
}

if (!PaymentService::verifySignature($oid, $pid, $sig)) { 
    echo json_encode(['success' => false]); 
    exit; 
}

Order::markPaid($oid, $pid, $sig);

// Decrease stock for all items
$items = Cart::items();
foreach ($items as $it) {
    Product::decreaseStock($it['id'], $it['qty']);
}

Cart::clear();

header('Content-Type: application/json');
echo json_encode(['success' => true]);
