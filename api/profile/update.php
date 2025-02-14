<?php
header("Content-Type: application/json");
include '../../utils/database.php';

try {
    $session_token = empty($_POST['session_token']) ? '' : $_POST['session_token'];
    $name = empty($_POST['name']) ? null : $_POST['name'];
    $username = empty($_POST['username']) ? null : $_POST['username'];
    $phone = empty($_POST['phone']) ? null : $_POST['phone'];
    $password = empty($_POST['password']) ? null : $_POST['password'];



    $stmt = $pdo->prepare("SELECT id FROM user WHERE session_token = ?");
    $stmt->execute([$session_token]);
    $session = $stmt->fetch();

    if (!$session) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid session']);
        exit;
    }

    $updateFields = [];
    $params = [];

    if ($name !== null) {
        $updateFields[] = 'name = ?';
        $params[] = $name;
    }

    if ($username !== null) {
        // Check username uniqueness
        $stmt = $pdo->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        $stmt->execute([$username, $session['user_id']]);
        if ($stmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
            exit;
        }

        $updateFields[] = 'username = ?';
        $params[] = $username;
    }

    if ($phone !== null) {
        $updateFields[] = 'phone = ?';
        $params[] = $phone;
    }

    if ($password !== null && $password !== '********') {
        $hashedPassword = sha1($password);
        $updateFields[] = 'password = ?';
        $params[] = $hashedPassword;
    }

    if (empty($updateFields)) {
        echo json_encode(['status' => 'error', 'message' => 'No fields to update']);
        exit;
    }

    $params[] = $session['id'];

    $query = "UPDATE user SET " . implode(', ', $updateFields) . " WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
