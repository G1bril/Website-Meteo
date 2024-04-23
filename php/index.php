<?php
// Inclure le fichier de connexion à la base de données
include 'db_connexion.php';

// Initialiser une réponse vide
$response = array();

// Vérifier si une session est active
session_start();
if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
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
    // Si aucune session n'est active ou si l'utilisateur n'est pas un administrateur, rediriger vers la page de connexion
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>CRUD - Contacts</title>
</head>

<body>
    <div class="gradient-background">
        <header role="banner">
            <div class="container">
                <nav class="navbar" role="navigation">
                    <a href="index.html" role="link">Accueil</a>
                    <a href="contact.html" role="link">Contact</a>
                    <a href="login.html" role="link">Se Connecter</a>
                    <a href="profile.html" role="link">Profile</a>
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
                <!-- Vous pouvez ajouter d'autres informations de profil ici -->
            </div>

            <h2>Ajouter un contact</h2>
            <form action="/meteo/php/index.php" method="post">
                <div>
                    <label>Nom</label>
                    <input type="text" name="name" value="">
                    <span></span>
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" name="email" value="">
                    <span></span>
                </div>
                <div>
                    <label>Message</label>
                    <textarea name="message"></textarea>
                    <span></span>
                </div>
                <div>
                    <input type="submit" value="Submit">
                    <input type="reset" value="Reset">
                </div>
            </form>

            <h2>Liste des contacts</h2>
            <table border="1">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Prepare a select statement
                $sql = "SELECT * FROM contacts";
                $stmt = $conn->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>";
                    echo "<a href='delete_contact.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this contact?')\">Supprimer</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <br>
            <a href="logout.php">Déconnexion</a>
        </div>

        <footer role="contentinfo">
            <div class="container">
                <p>&copy; 2024 Ma Météo. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</body>

</html>
