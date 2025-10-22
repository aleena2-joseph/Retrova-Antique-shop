<?php
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'retrova');
define('DB_USER', 'root');
define('DB_PASS', '');

// Auto-detect BASE_URL based on the actual directory structure
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
define('BASE_URL', $baseUrl);

define('RAZORPAY_KEY_ID', 'rzp_test_RV0yV2urkxFXQM');
define('RAZORPAY_KEY_SECRET', 'i2JCvv7IVXYIpcveFE649JPG');

// Register autoloader and initialize database via OOP layer
require_once __DIR__ . '/classes/Autoloader.php';
Database::init(DB_HOST, DB_NAME, DB_USER, DB_PASS);
