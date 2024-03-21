<?php
include '../php/db_connexion.php';
// Récupération des données envoyées par JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Variables du formulaire
$username = $data['username'];
$email = $data['email'];

$response = array(); // Initialiser une variable de réponse

try {
    // Préparation de la requête SQL pour vérifier les informations de connexion
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND email = :email");

    // Liaison des paramètres
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);

    // Exécution de la requête
    $stmt->execute();

    // Vérification de l'existence de l'utilisateur dans la base de données
    if ($stmt->rowCount() > 0) {
        // L'utilisateur est authentifié avec succès
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $response['username'] = $userData['username'];
        $response['email'] = $userData['email'];
    }
} catch (PDOException $e) {
    // En cas d'erreur, renvoie un message d'erreur JSON
    $response['error'] = "Erreur lors de la connexion: " . $e->getMessage();
}

// Envoyer la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);

// Fermeture de la connexion
$conn = null;
?>
