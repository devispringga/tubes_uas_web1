<?php
header("Content-Type: application/json");
include '../../utils/database.php';

try {
    $session_token = $_POST['session_token'] ?? '';

    $stmt = $pdo->prepare("SELECT id FROM user WHERE session_token = ?");
    $stmt->execute([$session_token]);
    $session = $stmt->fetch();

    if (!$session) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid session']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT name, username, phone FROM user WHERE id = ?");
    $stmt->execute([$session['id']]);
    $user = $stmt->fetch();

    if ($user) {
        echo json_encode([
            'status' => 'success',
            'data' => [
                'name' => $user['name'],
                'username' => $user['username'],
                'phone' => $user['phone']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>