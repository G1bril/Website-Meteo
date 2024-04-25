<?php
// Inclure le fichier de connexion à la base de données
include 'db_connexion.php';

// Initialiser une réponse vide
$response = array();

// Vérifier si une session est active
session_start();
if (isset($_SESSION['username'])) {
    // Si une session est active, récupérer les informations du profil de l'utilisateur
    $username = $_SESSION['username'];
    try {
        // Code pour récupérer les informations du profil de l'utilisateur depuis la base de données
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $profileData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifiez si des données ont été récupérées avec succès
        if ($profileData) {
            // Ajouter les données du profil à la réponse
            $response['username'] = $profileData['username'];
            $response['email'] = $profileData['email'];
            $response['ville'] = $profileData['ville'];
        } else {
            // Si aucun utilisateur n'est trouvé, ajoutez un message d'erreur à la réponse
            http_response_code(404); // Renvoyer un code d'erreur HTTP approprié
            $response['error'] = "Aucun profil trouvé pour cet utilisateur.";
        }
    } catch (PDOException $e) {
        // En cas d'erreur, ajouter un message d'erreur à la réponse
        http_response_code(500); // Renvoyer un code d'erreur HTTP approprié
        $response['error'] = "Erreur lors de la récupération des informations du profil: " . $e->getMessage();
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
