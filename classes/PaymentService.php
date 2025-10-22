<?php
class PaymentService
{
    public static function createRazorpayOrder(int $amountInPaise): ?array
    {
        $receipt = 'rcpt_' . time() . '_' . User::id();
        $payload = json_encode([
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'receipt' => $receipt,
            'payment_capture' => 1
        ]);
        
        $ch = curl_init('https://api.razorpay.com/v1/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($code !== 200) {
            return null;
        }
        
        return json_decode($resp, true);
    }

    public static function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, RAZORPAY_KEY_SECRET);
        return hash_equals($expectedSignature, $signature);
    }
}
