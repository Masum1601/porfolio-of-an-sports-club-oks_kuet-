<?php

$db_host = 'localhost';
$db_name = 'oks_kuet';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die('<div style="font-family:sans-serif;padding:40px;color:#d0302f;text-align:center;">
        <h2>Database Connection Failed</h2>
        <p>Make sure MySQL is running in XAMPP and the database <strong>oks_kuet</strong> exists.</p>
        <p>Run <a href="setup_database.php">setup_database.php</a> first to create the database.</p>
        <p style="color:#888;font-size:.85rem;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>
    </div>');
}
