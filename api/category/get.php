<?php
// database
include '../../utils/database.php';

// set tipe respon dalam format json
header('Content-Type: application/json');

// Query untuk mengambil data kategori
$sql = "SELECT id, name FROM category";
$result = $pdo->query($sql);
$result->execute();

$categories = [];

if ($result->rowCount() > 0) {
    // Ambil semua data kategori
    $categories = $result->fetchAll(PDO::FETCH_ASSOC);
    // Kirim response dalam format JSON
    echo json_encode(['status' => 'success', 'data' => $categories]);
} else {
    // Jika tidak ada data kategori
    echo json_encode(['status' => 'error', 'message' => 'No categories found']);
}

?>
