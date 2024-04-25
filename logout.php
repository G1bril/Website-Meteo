<?php
// Démarrer ou reprendre une session existante
session_start();

// Détruire toutes les données de session
$_SESSION = array();

// Détruire la session
session_unset();
session_destroy();
?>
