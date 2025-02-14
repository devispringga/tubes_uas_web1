<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../utils/database.php';

// Mengambil input
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
$password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

// Validasi input
if (!$name || !$username || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Semua kolom harus diisi']);
    exit();
}

// Validasi panjang password (misalnya minimal 6 karakter)
if (strlen($password) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Password harus minimal 6 karakter']);
    exit();
}

// Cek apakah username sudah terdaftar
$query = "SELECT COUNT(*) FROM user WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->execute(['username' => $username]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username sudah terdaftar']);
    exit();
}

// Enkripsi password menggunakan SHA1 (atau Anda bisa menggunakan bcrypt untuk lebih aman)
$passwordSHA = sha1($password);

// Query untuk insert data
$query = "INSERT INTO user (username, password, name) VALUES (:username, :password, :name)";
$stmt = $pdo->prepare($query);

try {
    $stmt->execute(['username' => $username, 'password' => $passwordSHA, 'name' => $name]);
    echo json_encode(['status' => 'success', 'message' => 'Registrasi Berhasil']);
} catch (PDOException $e) {
    // Tampilkan error jika ada masalah saat insert ke database
    echo json_encode(['status' => 'error', 'message' => 'Terjadi error: ' . $e->getMessage()]);
}
?>
