<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/auth.php';

requireLogin();
$user = getCurrentUser();

header('Content-Type: application/json');

$specs_id = (int)($_POST['specs_id'] ?? 0);
if (!$specs_id) { echo json_encode(['error' => 'Invalid item']); exit; }

$existing = dbFetch("SELECT id FROM tbl_wishlist WHERE user_id = ? AND specs_id = ?", [$user['id'], $specs_id]);

if ($existing) {
    dbExecute("DELETE FROM tbl_wishlist WHERE user_id = ? AND specs_id = ?", [$user['id'], $specs_id]);
    echo json_encode(['saved' => false]);
} else {
    dbExecute("INSERT INTO tbl_wishlist (user_id, specs_id) VALUES (?, ?)", [$user['id'], $specs_id]);
    echo json_encode(['saved' => true]);
}
