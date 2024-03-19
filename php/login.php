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
$password = $data['password'];

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);

    // Configuration des options PDO pour générer des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête SQL pour vérifier les informations de connexion
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");

    // Liaison des paramètres
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Exécution de la requête
    $stmt->execute();

    // Vérification de l'existence de l'utilisateur dans la base de données
    if ($stmt->rowCount() > 0) {
        // L'utilisateur est authentifié avec succès
        echo json_encode(array("message" => "Connexion réussie"));
    } else {
        // L'utilisateur n'existe pas ou les informations de connexion sont incorrectes
        echo json_encode(array("error" => "Identifiants incorrects"));
    }
} catch (PDOException $e) {
    // En cas d'erreur, renvoie un message d'erreur JSON
    echo json_encode(array("error" => "Erreur lors de la connexion: " . $e->getMessage()));
}

// Fermeture de la connexion
$conn = null;
?>