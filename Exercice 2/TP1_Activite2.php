<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php
	$nom = $_POST['nom'];
	$mdp = $_POST['mdp'];
	if($mdp == "math"){
		echo "Bravo $nom votre mot de passe est juste";
	}else{
		echo "Désolé Mr. $nom, votre mot de passe est incorrect <a href='TP2_Activite2.html'><input type='button' value='retour'></a>";
	}
	?>
</body>
</html>