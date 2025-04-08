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
    // Prepare SQL query to select user data from users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session and return success response
            $_SESSION['username'] = $username;
            echo json_encode(array("success" => true));
        } else {
            // Password is incorrect, return error response
            echo json_encode(array("error" => "Identifiants incorrects"));
        }
    } else {
        // User not found, return error response
        echo json_encode(array("error" => "Utilisateur non trouvé"));
    }
} catch (PDOException $e) {
    // If an error occurs during database operation, display error message
    echo json_encode(array("error" => "Erreur lors de la connexion: " . $e->getMessage()));
}
?>
