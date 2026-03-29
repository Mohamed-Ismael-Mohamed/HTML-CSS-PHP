<?php
$connexion = mysqli_connect("localhost", "root", "", "gestion_etudiant");
$nom = $_POST['nom'];
$mdp = $_POST['mdp'];
$res = mysqli_query($connexion, "select * from etudiants where Nom = '$nom' and Mot_de_passe = '$mdp'");
if (mysqli_num_rows($res)>0) {
	header("Location: menu.html");
	exit();
}else{
	echo "Le Nom de compte ou le Mot de passe sont incorrectes";
}
?>