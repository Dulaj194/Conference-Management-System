<?php
require_once 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $post = htmlspecialchars(trim($_POST['post']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($name) || empty($post) || empty($email) || empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    if (!$email) {
        echo json_encode(["status" => "error", "message" => "Invalid email address."]);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(["status" => "error", "message" => "Password must be at least 6 characters long."]);
        exit;
    }

    try {
        // Check if email or username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
        $stmt->execute(['email' => $email, 'username' => $username]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "Email or Username already exists."]);
            exit;
        }

        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, post, email, username, password) VALUES (:name, :post, :email, :username, :password)");
        $stmt->execute([
            'name' => $name,
            'post' => $post,
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword
        ]);

        echo json_encode(["status" => "success", "message" => "Registration successful!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
}
?>
