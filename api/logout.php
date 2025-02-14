<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include '../utils/database.php';

    $session_token = $_POST['session_token'];

    if (isset($session_token)) {
        $statement = $pdo->prepare("UPDATE user SET session_token = NULL WHERE session_token = ?");
        $statement->execute([$session_token]);

        $aftdRows = $statement->rowCount();
        if ($aftdRows > 0) {
            echo json_encode(['status' => 'success', 'hasil' => 'Logout Berhasil']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid session']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
?>