<?php
// Inclure le fichier de connexion à la base de données
include 'db_connexion.php';

// Initialiser une réponse vide
$response = array();

// Vérifier si une session est active
session_start();
if (isset($_SESSION['username'])) {
    // Si une session est active, récupérer le nom d'utilisateur
    $username = $_SESSION['username'];

    try {
        // Préparer et exécuter la requête pour supprimer le profil de l'utilisateur de la base de données
        $stmt = $conn->prepare("DELETE FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Vider la session
        session_unset();
        session_destroy();

        // Ajouter un message de succès à la réponse
        $response['success'] = "Le profil de l'utilisateur $username a été supprimé avec succès.";
    } catch (PDOException $e) {
        // En cas d'erreur, ajouter un message d'erreur à la réponse
        http_response_code(500); // Renvoyer un code d'erreur HTTP approprié
        $response['error'] = "Erreur lors de la suppression du profil de l'utilisateur : " . $e->getMessage();
    }
} else {
    // Si aucune session n'est active, renvoyer un code d'erreur HTTP 401 (non autorisé)
    http_response_code(401);
    $response['error'] = "Non autorisé";
    $response['redirect'] = "login.html"; // Ajouter l'URL de redirection
}

// Définir le type de contenu comme JSON
header('Content-Type: application/json');

// Renvoyer la réponse JSON
echo json_encode($response);
?>
