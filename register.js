document.addEventListener("DOMContentLoaded", function () {
    const signupButton = document.getElementById('signupButton');

    signupButton.addEventListener('click', function (event) {
        event.preventDefault(); // Empêche le comportement par défaut du bouton

        // Récupération des valeurs des champs du formulaire
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Vérification des champs vides
        if (username.trim() === "") {
            alert("Veuillez saisir votre nom d'utilisateur.");
            return;
        }
        if (email.trim() === "") {
            alert("Veuillez saisir votre adresse email.");
            return;
        }
        if (password === "") {
            alert("Veuillez saisir votre mot de passe.");
            return;
        }
        if (confirmPassword === "") {
            alert("Veuillez confirmer votre mot de passe.");
            return;
        }
        if (password !== confirmPassword) {
            alert("Les mots de passe ne correspondent pas.");
            return;
        }

        // Envoi des données au serveur avec fetch
        fetch('php/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: username,
                email: email,
                password: password,
                confirmPassword: confirmPassword
            })
        })
            .then(response => response.json())
            .then(data => {
                // Traitement de la réponse
                console.log(data);
                if (data.success) {
                    // Redirection vers la page de connexion
                    window.location.href = "login.html";
                } else {
                    // Afficher un message d'erreur si nécessaire
                    console.log(data);
                }
            })
    });
});
