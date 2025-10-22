<?php
require_once __DIR__ . '/../../functions.php';
requireAdmin();
$id = (int)($_GET['id'] ?? 0);
Product::delete($id);
header('Location: index.php');
