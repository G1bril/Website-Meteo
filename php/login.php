<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include '../php/db_connexion.php';

// Start or resume the session
session_start();

// Retrieve data sent by JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Variables from the form
$username = $data['username'];
$password = $data['password'];

try {
    // Prepare SQL query to check login credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Check if user exists in database
    if ($stmt->rowCount() > 0) {
        // User is authenticated successfully
        // Store user data in session
        $_SESSION['username'] = $username;

        // Return success response
        echo json_encode(array("success" => true));
    } else {
        // User does not exist or login credentials are incorrect
        // Clear any existing session data
        session_unset();
        session_destroy();

        echo json_encode(array("error" => "Identifiants incorrects"));
    }
} catch (PDOException $e) {
    // If an error occurs during database operation, display error message
    // Clear any existing session data
    session_unset();
    session_destroy();

    echo json_encode(array("error" => "Erreur lors de la connexion: " . $e->getMessage()));
}
?>
