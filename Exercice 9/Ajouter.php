<?php
$connexion = mysqli_connect("localhost","root","","gestion_etudiant");
$num = $_POST["numero"];
$nom_prenom = $_POST["nom_prenom"];
$mdp = $_POST["mdp"];
$sexe = $_POST["sexe"];
$filiere = $_POST["filiere"];
$mail = $_POST["mail"];
$adresse = $_POST["adresse"];

$res = mysqli_query($connexion, "Insert into etudiants(Numero, Nom, Mot_de_passe, Sexe, Filiere, Email, Adresse) values($num, '$nom_prenom', '$mdp', '$sexe', '$filiere', '$mail', '$adresse')");
if ($res) {
	echo "Vos Information ont bien ete enregistrer !";
}
else{
	echo "Il y a eu une erreur !";
}
?>