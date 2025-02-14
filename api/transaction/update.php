<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include '../../utils/database.php';

    /// ngecek apakah ada datanya
    if (!isset($_POST['session_token']) || !isset($_POST['transaction_id']) || !isset($_POST['amount']) || !isset($_POST['idcategory']) || !isset($_POST['statustransaction']) || !isset($_POST['date'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit();
    }
    
    // ngecek amount apakah integer
    if (!filter_var($_POST['amount'], FILTER_VALIDATE_INT) || $_POST['amount'] < 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid amount']);
        exit();
    }
    $amount = $_POST['amount'];

    // ngecek categoryid apakah integer
    if (!filter_var($_POST['idcategory'], FILTER_VALIDATE_INT)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid idcategory']);
        exit();
    }
    $idcategory = $_POST['idcategory'];

    // ngecek statustransaction apakah boolean atau integer
    $statustransaction = filter_var($_POST['statustransaction'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    if ($statustransaction === null) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid statustransaction (must be a boolean)']);
        exit();
    }

    // ngecek date format
    $date = $_POST['date'];
    $datetime = DateTime::createFromFormat('Y-m-d', $date);
    if (!$datetime || $datetime->format('Y-m-d') !== $date) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid date format. Use YYYY-MM-DD']);
        exit();
    }

    // ngecek apakah ada usernya
    $userCheckQuery = "SELECT id FROM user WHERE session_token = ?";
    $stmt = $pdo->prepare($userCheckQuery);
    $stmt->execute([$_POST['session_token']]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit();
    }
    $userids = $stmt->fetch();

    // ngecek apakah categorynya ada
    $categoryCheckQuery = "SELECT id FROM category WHERE id = ?";
    $stmt = $pdo->prepare($categoryCheckQuery);
    $stmt->execute([$idcategory]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Category not found']);
        exit();
    }

    // cek apakah transaksi dengan ID yang diberikan ada
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
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized to edit this transaction']);
        exit();
    }

    // Update transaksi
    $updateQuery = "UPDATE transaction 
                    SET amount = :amount, categoryid = :categoryid, statusTransaksi = :statusTransaksi, date = :date 
                    WHERE id = :transaction_id";
    $stmt = $pdo->prepare($updateQuery);

    try {
        $stmt->execute([
            'amount' => $amount,
            'categoryid' => $idcategory,
            'statusTransaksi' => $statustransaction,
            'date' => $date,
            'transaction_id' => $_POST['transaction_id']
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Transaction updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error updating transaction: ' . $e->getMessage()]);
    }
?>
