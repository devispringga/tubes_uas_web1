<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include '../utils/database.php';
    
    $session_token = $_POST['session_token'];

    if (isset($session_token)) {
        $statement = $pdo->prepare("SELECT name FROM user WHERE session_token = ?");
        $statement->execute([$session_token]);
        $user = $statement->fetch();

        if ($user) {
            echo json_encode(['status' => 'success', 'hasil' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid session']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
?>