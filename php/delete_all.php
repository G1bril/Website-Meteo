<?php
// Inclure le fichier de connexion à la base de données
include 'db_connexion.php';

// Vérifier si l'ID de l'utilisateur à supprimer est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Récupérer l'ID de l'utilisateur à supprimer
    $id = $_GET['id'];

    try {
        // Préparer et exécuter la requête pour supprimer l'utilisateur de la base de données
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Rediriger vers la page de profil après suppression
        header("Location: ../profile.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
} else {
    // Si l'ID de l'utilisateur n'est pas spécifié dans l'URL, afficher un message d'erreur
    echo "ID de l'utilisateur non spécifié.";
}
?>
