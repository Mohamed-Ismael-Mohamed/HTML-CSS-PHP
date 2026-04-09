<?php
// Informations de connexion
$host = "localhost";
$user = "root"; 
$password = ""; // Par défaut vide sur XAMPP/WAMP
$dbname = "projet_web";

// Création de la connexion
$connexion = mysqli_connect($host, $user, $password, $dbname);

// Vérification de la connexion
if (!$connexion) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Pour gérer les accents (UTF-8)
mysqli_set_charset($connexion, "utf8");
?>