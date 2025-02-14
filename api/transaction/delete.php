<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include '../../utils/database.php';

    // Mengecek apakah semua parameter ada dalam request
    if (!isset($_POST['session_token']) || !isset($_POST['transaction_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit();
    }

    // Mengecek apakah user ada
    $userCheckQuery = "SELECT id FROM user WHERE session_token = ?";
    $stmt = $pdo->prepare($userCheckQuery);
    $stmt->execute([$_POST['session_token']]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit();
    }
    $userids = $stmt->fetch();

    // Mengecek apakah transaksi ada
    $transactionCheckQuery = "SELECT id, userid FROM transaction WHERE id = ?";
    $stmt = $pdo->prepare($transactionCheckQuery);
    $stmt->execute([$_POST['transaction_id']]);
    
    if ($stmt->rowCount() === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Transaction not found']);
        exit();
    }
    $transaction = $stmt->fetch();

    // Pastikan transaksi milik user yang valid
    if ($transaction['userid'] !== $userids['id']) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized to delete this transaction']);
        exit();
    }

    // Hapus transaksi
    $deleteQuery = "DELETE FROM transaction WHERE id = :transaction_id";
    $stmt = $pdo->prepare($deleteQuery);

    try {
        $stmt->execute(['transaction_id' => $_POST['transaction_id']]);
        echo json_encode(['status' => 'success', 'message' => 'Transaction deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting transaction: ' . $e->getMessage()]);
    }
?>
