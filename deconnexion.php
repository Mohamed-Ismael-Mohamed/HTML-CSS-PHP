<?php
session_start();

// On vide toutes les variables de session (panier, id_client, etc.)
session_unset();

// On détruit la session sur le serveur
session_destroy();

// On redirige vers l'accueil
header("Location: ACUEILL.html");
exit();
?>