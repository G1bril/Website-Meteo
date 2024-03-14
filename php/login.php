<?php
// Connexion à la base de données
$servername = "localhost"; // Adresse du serveur MySQL
$username = "votre_nom_utilisateur"; // Nom d'utilisateur MySQL
$password = "votre_mot_de_passe"; // Mot de passe MySQL
$dbname = "votre_base_de_donnees"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupération des données du formulaire
$username = $_REQUEST['username'];
$password = $_REQUEST["password"];

// Requête SQL pour récupérer l'utilisateur correspondant au nom d'utilisateur
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Utilisateur trouvé, vérification du mot de passe
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
        echo "Connexion réussie";
    } else {
        echo "Le nom d'utilisateur ou le mot de passe est incorrect";
    }
} else {
    echo "Le nom d'utilisateur ou le mot de passe est incorrect";
}

// Fermeture de la connexion
$conn->close();
?>
