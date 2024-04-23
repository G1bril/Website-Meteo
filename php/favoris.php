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

    // Vérifier si la ville a été soumise
    if (isset($_POST['ville'])) {
        $ville = $_POST['ville'];

        try {
            // Préparer et exécuter la requête pour insérer la ville favorite de l'utilisateur dans la base de données
            $stmt = $conn->prepare("UPDATE users SET ville = :ville WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':ville', $ville);
            $stmt->execute();

            // Ajouter un message de succès à la réponse
            $response['success'] = "La ville $ville a été ajoutée aux favoris de l'utilisateur $username avec succès. Pensez à rafraichir la page.";
        } catch (PDOException $e) {
            // En cas d'erreur, ajouter un message d'erreur à la réponse
            http_response_code(500); // Renvoyer un code d'erreur HTTP approprié
            $response['error'] = "Erreur lors de l'ajout de la ville aux favoris de l'utilisateur : " . $e->getMessage();
        }
    } else {
        // Si aucune ville n'a été soumise, ajouter un message d'erreur à la réponse
        http_response_code(400); // Renvoyer un code d'erreur HTTP approprié
        $response['error'] = "Aucune ville n'a été soumise.";
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