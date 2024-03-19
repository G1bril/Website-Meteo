<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Données de connexion à la base de données
$servername = "localhost"; // Adresse du serveur MySQL
$dbusername = "root"; // Nom d'utilisateur MySQL
$dbpassword = ""; // Mot de passe MySQL
$dbname = "meteo"; // Nom de la base de données

// Récupération des données envoyées par JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Variables du formulaire
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$confirmPassword = $data['confirmPassword'];

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);

    // Configuration des options PDO pour générer des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête SQL pour l'insertion des données
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

    // Liaison des paramètres
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    // Exécution de la requête
    $stmt->execute();

    // Réponse JSON en cas de succès
    echo json_encode(array("success" => true));
    

} catch (PDOException) {
    // En cas d'erreur lors de l'inscription (par exemple, erreur de connexion à la base de données)
    // Renvoyer un message d'erreur JSON
    echo json_encode(array("success" => false, "error" => "Erreur lors de l'inscription: "));
} finally {
    // Fermeture de la connexion
    $conn = null;
}
?>
