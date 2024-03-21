document.addEventListener("DOMContentLoaded", function () {
    const loginButton = document.getElementById('loginButton');

    loginButton.addEventListener('click', function (event) {
        event.preventDefault(); // Empêche le comportement par défaut du bouton

        // Récupération des valeurs des champs du formulaire
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Vérification des champs vides
        if (username.trim() === "") {
            alert("Veuillez saisir votre nom d'utilisateur.");
            return;
        }
        if (password === "") {
            alert("Veuillez saisir votre mot de passe.");
            return;
        }

        // Envoi des données au serveur avec fetch
        fetch('php/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: username,
                password: password
            })
        })
            .then(response => response.json())
            .then(data => {
                // Traitement de la réponse
                console.log(data);
                if (data.success) {
                    // Redirection vers la page de profil
                    window.location.href = "profile.html";
                } else {
                    // Afficher un message d'erreur si nécessaire
                    console.error('Erreur lors de la réception des données:', data.error);
                    alert("Identifiants incorrecte.");
                }
            })
            .catch(error => {
                // Gérer les erreurs de requête
                console.error('Erreur lors de l\'envoi des données:', error);
            });
    });
});
