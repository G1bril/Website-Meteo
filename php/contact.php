<?php
// Include database connection
include 'db_connexion.php';

// Initialize an empty response array
$response = array();

// Check if the form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        // Prepare the SQL statement for insertion
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        // Execute the prepared statement
        $stmt->execute();

        // Success message
        $response['success'] = "Votre message à bien été envoyé!";
    } catch(PDOException $e) {
        // Error message
        $response['error'] = "Error sending message: " . $e->getMessage();
    }
} else {
    // If the form is not submitted via POST method
    $response['error'] = "Invalid request method!";
}

// Set content type as JSON
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($response);
?>
