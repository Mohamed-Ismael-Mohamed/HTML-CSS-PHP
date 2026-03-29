<?php
$connexion = mysqli_connect("localhost","root","","gestion_etudiant");
$num_supp = $_POST["num_supp"];
$res = mysqli_query($connexion, "delete from etudiants where Numero = $num_supp");
if ($res) {
	echo "La personne a bien été SUPPRIMER ! ";
}else{
	echo "Erreur";
}
?>