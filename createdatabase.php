<?php
// Database credentials
$host = 'localhost';
$dbname = 'irc2024';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    // Establish connection to MySQL server (without selecting a specific database)
    $dsn = "mysql:host=$host;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database '$dbname' created or already exists.<br>";

    // Switch to the created database
    $pdo->exec("USE $dbname");

    // Create the 'users' table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            post VARCHAR(50) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Table 'users' created or already exists.<br>";

    // Success message
    echo "Database and table setup complete!";
} catch (PDOException $e) {
    die("Database setup or connection failed: " . $e->getMessage());
}
?>
