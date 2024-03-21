document.addEventListener("DOMContentLoaded", function () {
    // Récupérer les informations du profil de l'utilisateur depuis le serveur
    fetch('php/get_profile.php')
        .then(response => response.json())
        .then(data => {
            // Afficher les informations du profil de l'utilisateur dans la page
            document.getElementById('username').innerText = data.username;
            document.getElementById('email').innerText = data.email;
            // Vous pouvez ajouter d'autres informations de profil ici
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des informations du profil:', error);
            // Afficher un message d'erreur à l'utilisateur si nécessaire
        });
});
