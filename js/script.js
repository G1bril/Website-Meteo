// Définition de la clé API et de l'URL de l'API OpenWeatherMap
const apiKey = '2962802eb10e823968a8430629f72725';
const apiUrl = 'https://api.openweathermap.org/data/2.5/weather';

// Récupération des éléments HTML avec leurs IDs correspondants
const locationInput = document.getElementById('locationInput');
const searchButton = document.getElementById('searchButton');
const locationElement = document.getElementById('location');
const temperatureElement = document.getElementById('temperature');
const descriptionElement = document.getElementById('description');
const iconsElement = document.getElementById('icons');

// Ajout d'un gestionnaire d'événement pour détecter quand l'utilisateur appuie sur une touche dans le champ de recherche
locationInput.addEventListener("keypress", function (event) {
    // Si l'utilisateur appuie sur la touche "Entrée"
    if (event.key === "Enter") {
        // Annule l'action par défaut, si nécessaire
        event.preventDefault();
        // Déclenche l'événement de clic sur le bouton de recherche
        document.getElementById("searchButton").click();
    }
});

// Ajout d'un gestionnaire d'événement pour détecter quand l'utilisateur clique sur le bouton de recherche
searchButton.addEventListener('click', () => {
    // Récupère la valeur saisie par l'utilisateur dans le champ de recherche
    const location = locationInput.value;
    // Vérifie si une valeur est saisie
    if (location) {
        // Si oui, appelle la fonction fetchWeather pour obtenir les données météorologiques
        fetchWeather(location);
    }
});

// Fonction pour récupérer les données météorologiques en utilisant l'API OpenWeatherMap
function fetchWeather(location) {
    // Construction de l'URL de l'API avec la ville saisie par l'utilisateur
    const url = `${apiUrl}?q=${location}&appid=${apiKey}&units=metric&lang=fr`;

    // Appel de l'API en utilisant fetch
    fetch(url)
        .then(response => response.json()) // Convertit la réponse en JSON
        .then(data => {
            // Mise à jour des éléments HTML avec les données météorologiques obtenues
            locationElement.textContent = data.name;
            temperatureElement.textContent = `${Math.round(data.main.temp)}°C`;
            descriptionElement.textContent = data.weather[0].description;
            const weatherIcon = getWeatherIcon(data.weather[0].icon);
            iconsElement.innerHTML = `<img src="${weatherIcon}" alt="Weather Icon">`;
        })
        .catch(error => {
            // En cas d'erreur, affiche un message d'erreur
            console.error('Error fetching weather data:', error);
            window.alert('Le nom de la ville entrée est incorrecte');
        });
}

// Fonction pour obtenir l'URL de l'icône météorologique à partir du code d'icône
function getWeatherIcon(iconCode) {
    const iconBaseUrl = 'http://openweathermap.org/img/wn/';
    const iconExtension = '@2x.png';
    const iconUrl = `${iconBaseUrl}${iconCode}${iconExtension}`;
    return iconUrl;
}



 // Sélectionnez l'élément par son ID
// var button = document.getElementById('alert-trigger');
 //var alertButton = document.getElementById('alertButton');
 // Ajoutez un gestionnaire d'événements de clic
 //button.addEventListener('click', function() {
//  alertButton.innerHTML = "<h1>ALERTE</h1>";