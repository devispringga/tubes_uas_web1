<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include '../utils/database.php';

    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

    if ($username & $password) {
        $query = "SELECT id, username, password FROM user WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && sha1($password) == $user['password'] ) {
            $session_token = bin2hex(random_bytes(16));

            $updateStatement = $pdo->prepare("UPDATE user SET session_token = ? WHERE id = ?");
            $updateStatement->execute([$session_token, $user['id']]);

            echo json_encode(['status' => 'success', 'session_token' => $session_token]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'kredensial tidak valid']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid']);
    }
?>