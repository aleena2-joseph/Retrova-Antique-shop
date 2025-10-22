<?php
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'retrova');
define('DB_USER', 'root');
define('DB_PASS', '');

define('BASE_URL', '/Retrova');

define('RAZORPAY_KEY_ID', 'rzp_test_RV0yV2urkxFXQM');
define('RAZORPAY_KEY_SECRET', 'i2JCvv7IVXYIpcveFE649JPG');

// Register autoloader and initialize database via OOP layer
require_once __DIR__ . '/classes/Autoloader.php';
Database::init(DB_HOST, DB_NAME, DB_USER, DB_PASS);
