<?php
// Inclure le fichier de connexion à la base de données
include 'db_connexion.php';

// Initialiser une réponse vide
$response = array();

// Vérifier si l'ID du contact à supprimer est défini et n'est pas vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Récupérer l'ID du contact à supprimer
    $id = $_GET['id'];

    try {
        // Préparer et exécuter la requête pour supprimer le contact de la base de données
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Ajouter un message de succès à la réponse
        $response['success'] = "L'utilisateur a été supprimé avec succès.";
    } catch (PDOException $e) {
        // En cas d'erreur, ajouter un message d'erreur à la réponse
        http_response_code(500); // Renvoyer un code d'erreur HTTP approprié
        $response['error'] = "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
} else {
    // Si l'ID du contact à supprimer n'est pas défini ou est vide, renvoyer un code d'erreur HTTP 400 (mauvvaise requête)
    http_response_code(400);
    $response['error'] = "ID de l'utilisateur non spécifié.";
}

// Définir le type de contenu comme JSON
header('Content-Type: application/json');

// Renvoyer la réponse JSON
echo json_encode($response);
?>
