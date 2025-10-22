<?php
class Formatter
{
    public static function inr(float $amount): string
    {
        return '₹' . number_format((float)$amount, 2);
    }
}
