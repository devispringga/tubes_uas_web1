<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../utils/database.php';

// Memastikan session_token ada
if (!isset($_GET['session_token'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session token is required']);
    exit();
}

$session_token = $_GET['session_token'];

// Memeriksa apakah pengguna ada berdasarkan session_token
$userCheckQuery = "SELECT id FROM user WHERE session_token = ?";
$stmt = $pdo->prepare($userCheckQuery);
$stmt->execute([$session_token]);

if ($stmt->rowCount() === 0) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit();
}

$user = $stmt->fetch();
$user_id = $user['id'];

$transactions = [];

try {
    if (!isset($_GET['id'])) {
        $query = "SELECT t.id, t.amount, t.date, t.statusTransaksi, c.name AS category 
                  FROM transaction t
                  JOIN category c ON t.categoryid = c.id
                  WHERE t.userid = ?
                  ORDER BY t.date DESC"; // Urutkan berdasarkan tanggal, yang terbaru lebih dulu
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = "SELECT * FROM transaction WHERE id = ?";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_GET['id']]);
        $transactions = $stmt->fetch();

        if ($user_id !==  $transactions['userid']) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
            exit();
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $transactions
    ]);
} catch (PDOException $e)  {
    echo json_encode([
        'status' => 'error',
        'message' => $e
    ]);
}

