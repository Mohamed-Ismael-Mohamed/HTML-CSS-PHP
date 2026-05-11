<?php
$host = "localhost";
$user = "root"; 
$password = ""; 
$dbname = "projet_web";

$connexion = mysqli_connect($host, $user, $password, $dbname);

if (!$connexion) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

mysqli_set_charset($connexion, "utf8");
?>