<?php
class Order
{
    public static function create(int $userId, string $razorpayOrderId, int $amount): int
    {
        $st = Database::conn()->prepare('INSERT INTO orders (user_id, razorpay_order_id, amount, status) VALUES (?, ?, ?, \'created\')');
        $st->execute([$userId, $razorpayOrderId, $amount]);
        $orderId = (int)Database::conn()->lastInsertId();
        
        // Save order items
        $items = Cart::items();
        if ($items) {
            $st = Database::conn()->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            foreach ($items as $item) {
                $st->execute([$orderId, $item['id'], $item['qty'], $item['price']]);
            }
        }
        
        return $orderId;
    }

    public static function markPaid(string $razorpayOrderId, string $razorpayPaymentId, string $razorpaySignature): bool
    {
        $st = Database::conn()->prepare('UPDATE orders SET razorpay_payment_id=?, razorpay_signature=?, status=\'paid\' WHERE razorpay_order_id=?');
        return $st->execute([$razorpayPaymentId, $razorpaySignature, $razorpayOrderId]);
    }

    public static function markFailed(string $razorpayOrderId): bool
    {
        $st = Database::conn()->prepare('UPDATE orders SET status=\'failed\' WHERE razorpay_order_id=?');
        return $st->execute([$razorpayOrderId]);
    }
}
