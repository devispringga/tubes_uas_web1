<?php
    // Local Database
    $dsn = "mysql:host=localhost;dbname=cuanbijak;charset=utf8mb4";
    $usernameDB = "root";
    $passwordDB = "123456";

    // Server Database
    //$dsn = "mysql:host=localhost;dbname=novx1544_devispringga;charset=utf8mb4";
    //$usernameDB = "novx1544_devis_pringga";
    //$passwordDB = "@Devis123456";
    
    
    try {
        $pdo = new PDO($dsn, $usernameDB, $passwordDB);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Custom session management using cookies
    function setSessionCookie($name, $value, $expiry = 3600) {
        setcookie($name, $value, time() + $expiry, "/", "", true, true);
    }

    function getSessionCookie($name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    function deleteSessionCookie($name) {
        setcookie($name, "", time() - 3600, "/", "", true, true);
    }
?>