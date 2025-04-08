<?php
// Inclure le fichier de connexion à la base de données
include 'php/db_connexion.php';

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
    // Si aucune session n'est active, rediriger vers la page de connexion
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Mon Profil - Ma Météo</title>
    <script src="js/profile.js"></script>
    <script src="js/logout.js"></script>
</head>

<body>
    <div class="gradient-background">
        <header role="banner">
            <div class="container">
                <nav class="navbar" role="navigation">
                    <a href="index.html" role="link">Accueil</a>
                    <a href="contact.html" role="link">Contact</a>
                    <a href="login.html" role="link">Se Connecter</a>
                    <a href="profile.php" role="link">Profile</a>
                    <a href="about.html" role="link">À propos</a>
                </nav>
            </div>
        </header>
        <div class="container" role="main">
            <h1>Mon Profil</h1>
            <div class="profile-info">
                <p><strong>Nom d'utilisateur :</strong> <?php echo $response['username']; ?></p>
                <p><strong>Email :</strong> <?php echo $response['email']; ?></p>
                <p><strong>Ville favorite :</strong> <?php echo $response['ville']; ?></p>
                <button type="submit" id="logoutButton" aria-label="Se déconnecter">Se déconnecter</button>
                <!-- Vous pouvez ajouter d'autres informations de profil ici -->
            </div>


            <form action="php/favoris.php" method="POST">
                <label for="ville">Choisir une ville favorite:</label>
                <select name="ville" id="ville">
                    <option value="Paris">Paris</option>
                    <option value="Londres">Londres</option>
                    <option value="New York">New York</option>
                    <option value="Tokyo">Tokyo</option>
                    <option value="Sydney">Sydney</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="Le Caire">Le Caire</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Pékin">Pékin</option>
                    <option value="Moscou">Moscou</option>
                    <option value="Rome">Rome</option>
                    <option value="Berlin">Berlin</option>
                    <option value="Madrid">Madrid</option>
                    <option value="Istanbul">Istanbul</option>
                    <option value="Dubai">Dubai</option>
                    <option value="Singapour">Singapour</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Buenos Aires">Buenos Aires</option>
                    <option value="Mexico City">Mexico City</option>
                    <option value="Toronto">Toronto</option>
                    <option value="Calcutta">Calcutta</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Le Cap">Le Cap</option>
                    <option value="Nairobi">Nairobi</option>
                    <option value="Lagos">Lagos</option>
                    <option value="Calcutta">Calcutta</option>
                    <option value="Hanoï">Hanoï</option>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="Chicago">Chicago</option>
                    <option value="Miami">Miami</option>
                    <option value="Santiago">Santiago</option>
                    <option value="Lima">Lima</option>
                    <option value="Bogotá">Bogotá</option>
                    <option value="Caracas">Caracas</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="São Paulo">São Paulo</option>
                    <option value="Montréal">Montréal</option>
                    <option value="Vancouver">Vancouver</option>
                    <option value="Ottawa">Ottawa</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Durban">Durban</option>
                    <option value="Abuja">Abuja</option>
                    <option value="Accra">Accra</option>
                    <option value="Addis-Abeba">Addis-Abeba</option>
                    <option value="Alger">Alger</option>
                    <option value="Ankara">Ankara</option>
                    <option value="Athènes">Athènes</option>
                    <option value="Bagdad">Bagdad</option>
                    <option value="Bangalore">Bangalore</option>
                    <option value="Bucarest">Bucarest</option>
                    <option value="Budapest">Budapest</option>
                    <option value="Le Caire">Le Caire</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Dubai">Dubai</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Karachi">Karachi</option>
                    <option value="Calcutta">Calcutta</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Lagos">Lagos</option>
                    <option value="Manille">Manille</option>
                    <option value="Mexico City">Mexico City</option>
                    <option value="Moscou">Moscou</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Nairobi">Nairobi</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="Riyad">Riyad</option>
                    <option value="São Paulo">São Paulo</option>
                    <option value="Shanghai">Shanghai</option>
                    <option value="Singapour">Singapour</option>
                    <option value="Sydney">Sydney</option>
                    <option value="Téhéran">Téhéran</option>
                    <option value="Tel Aviv">Tel Aviv</option>
                    <option value="Tokyo">Tokyo</option>
                    <option value="Toronto">Toronto</option>
                    <option value="Washington DC">Washington DC</option>
                </select>
                <input type="submit" value="Submit">
            </form>
            <a href="confirm.html"><button type="button">Supprimer le profile</button></a>
            </br>
            <?php if ($_SESSION['username'] === 'admin'): ?>
                <a href="php/index.php" role="link">Panneau Administrateur</a>
            <?php endif; ?>
        </div>

        <footer role="contentinfo">
            <div class="container">
                <p>&copy; 2024 Ma Météo. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</body>

</html>