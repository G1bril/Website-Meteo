<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include '../php/db_connexion.php';

// Retrieve data sent by JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Variables from the form
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];

try {
    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert data into users table
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_hash);
    $stmt->execute();

    // JSON response on success
    echo json_encode(array("success" => true));
} catch (PDOException $e) {
    // If an error occurs during database operation, display error message
    echo json_encode(array("success" => false, "error" => "Erreur lors de l'inscription: " . $e->getMessage()));
}
?>
