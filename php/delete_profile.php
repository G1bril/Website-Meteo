<?php
// Include the database connection file
include 'db_connexion.php';

// Initialize an empty response array
$response = array();

// Start or resume the session
session_start();

// Check if a session is active
if (isset($_SESSION['username'])) {
    // Get the username of the logged-in user
    $logged_in_username = $_SESSION['username'];

    try {
        // Prepare and execute the query to delete the user profile from the database
        $stmt = $conn->prepare("DELETE FROM users WHERE username = :username");
        $stmt->bindParam(':username', $logged_in_username);
        $stmt->execute();

        // Check if any row was affected
        if ($stmt->rowCount() > 0) {
            // Add a success message to the response
            $response['success'] = "Your profile has been successfully deleted.";
            // Clear session data
            session_unset();
            session_destroy();
        } else {
            // If no row was affected, it means the user is not authorized to delete this profile
            http_response_code(401); // Unauthorized
            $response['error'] = "You are not authorized to delete this profile.";
        }
    } catch (PDOException $e) {
        // In case of error, add an error message to the response
        http_response_code(500); // Send an appropriate HTTP error code
        $response['error'] = "Error deleting user profile: " . $e->getMessage();
    }
} else {
    // If no session is active, send a 401 (Unauthorized) error response
    http_response_code(401);
    $response['error'] = "Unauthorized";
}

// Set content type as JSON
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);
?>
