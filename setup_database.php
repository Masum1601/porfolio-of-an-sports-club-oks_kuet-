<?php
/**
 * Database Setup Script — Run this ONCE to create the database and tables.
 * Visit: http://localhost/oks_portfolio/setup_database.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

try {
    // Connect without specifying a database first
    $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Create the database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS oks_kuet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE oks_kuet");

    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            is_admin TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    // Create contact_submissions table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contact_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT DEFAULT NULL,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL,
            subject VARCHAR(50) NOT NULL,
            message TEXT NOT NULL,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB
    ");

    // Seed a default admin user (password: admin123)
    $adminEmail = 'admin@oks.kuet.ac.bd';
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$adminEmail]);

    if (!$stmt->fetch()) {
        $adminHash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, is_admin) VALUES (?, ?, ?, 1)");
        $stmt->execute(['OKS Admin', $adminEmail, $adminHash]);
    }

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup — OKS KUET</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--off-white);">
    <div style="background:var(--white);padding:48px;border-radius:var(--radius);box-shadow:var(--shadow-md);text-align:center;max-width:520px;">
        <div style="font-size:3rem;margin-bottom:16px;">✅</div>
        <h2 style="font-family:Poppins,sans-serif;color:var(--navy);margin-bottom:12px;">Database Setup Complete!</h2>
        <p style="color:var(--text-muted);margin-bottom:8px;">The <strong>oks_kuet</strong> database has been created with the following tables:</p>
        <ul style="text-align:left;color:var(--text-dark);margin:16px auto;max-width:300px;list-style:disc;padding-left:20px;">
            <li><strong>users</strong> — stores registered members</li>
            <li><strong>contact_submissions</strong> — stores contact form messages</li>
        </ul>
        <div style="background:rgba(26,107,60,.1);border:1px solid var(--green);border-radius:var(--radius-sm);padding:14px;margin:20px 0;text-align:left;">
            <strong style="color:var(--green);">Default Admin Account:</strong><br>
            <span style="color:var(--text-muted);font-size:.9rem;">
                Email: <code>admin@oks.kuet.ac.bd</code><br>
                Password: <code>admin123</code>
            </span>
        </div>
        <a href="index.php" class="btn btn--primary" style="margin-top:12px;">Go to Homepage →</a>
    </div>
</body>
</html>';

} catch (PDOException $e) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Error — OKS KUET</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--off-white);">
    <div style="background:var(--white);padding:48px;border-radius:var(--radius);box-shadow:var(--shadow-md);text-align:center;max-width:520px;">
        <div style="font-size:3rem;margin-bottom:16px;">❌</div>
        <h2 style="font-family:Poppins,sans-serif;color:#d0302f;margin-bottom:12px;">Setup Failed</h2>
        <p style="color:var(--text-muted);margin-bottom:16px;">Make sure MySQL is running in your XAMPP Control Panel.</p>
        <p style="color:#d0302f;font-size:.85rem;background:#fff0f0;padding:12px;border-radius:var(--radius-sm);">' . htmlspecialchars($e->getMessage()) . '</p>
    </div>
</body>
</html>';
}
