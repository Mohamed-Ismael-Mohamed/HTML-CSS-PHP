<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<center>
		<h1>Les Informations saisie sont :</h1><br><br>
		<?php
		$Numero = $_POST['Numero'];
		$Nom_prenom = $_POST['Nom_prenom'];
		$mdp = $_POST['mdp'];
		$Sexe = $_POST['Sexe'];
		$Filiere = $_POST['Filiere'];
		$email = $_POST['email'];
		$Adresse = $_POST['Adresse'];
		echo "Votre numero est : $Numero <br><br><br>";
		echo "Votre nom est : $Nom_prenom <br><br><br>";
		echo "Votre mot de passe est : $mdp <br><br><br>";
		if ($Sexe == "M") {
			echo "Votre Sexe est : masculin <br><br><br>";
		}else{
			echo "Votre Sexe est : feminin <br><br><br>";
		}
		echo "La filière choisie est : $Filiere <br><br><br>";
		echo "Votre Email est : $email <br><br><br>";
		echo "Votre adresse est : $Adresse <br><br><br>";
		?>
	</center>
</body>
</html>