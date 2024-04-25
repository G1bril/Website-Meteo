document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById('logoutButton');

    logoutButton.addEventListener('click', function (event) {
        event.preventDefault();

        // Envoi d'une requête au script PHP pour détruire la session
        fetch('php/logout.php')
            .then(response => {
                if (response.ok) {
                    // Redirection vers la page de connexion si la déconnexion est réussie
                    window.location.href = "login.html";
                } else {
                    // Affichage d'un message d'erreur si la déconnexion échoue
                    console.error("Erreur lors de la déconnexion");
                }
            })
            .catch(error => {
                console.error("Erreur lors de la déconnexion:", error);
            });
    });
});
