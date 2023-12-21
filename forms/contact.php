<?php
// Establish database connection
$host = 'localhost';
$db = 'ruhbanab_contact';
$user = 'ruhbanab_contact';
$password = 'rUHBAN@12';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Store the message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $timestamp = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message, timestamp) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message, $timestamp]);

    session_start();
    $_SESSION['message_sent'] = true;
    // Redirect to a success page
    header("Location: success.php");
    exit();
}
?>
