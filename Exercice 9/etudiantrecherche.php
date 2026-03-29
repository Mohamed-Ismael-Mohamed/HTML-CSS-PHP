<?php
	$connexion = mysqli_connect("localhost", "root", "", "gestion_etudiant");
	$num_rech = $_POST["num_rech"];
	$res = mysqli_query($connexion, "select * from etudiants where Numero = $num_rech");
	echo "<center>";
	echo " <table border=1>
			<tr>
				<th>Numero</th>
				<th>Nom et Prenom</th>
				<th>Mot de passe</th>
				<th>Sexe</th>
				<th>Filiere</th>
				<th>Email</th>
				<th>Adresse</th>
			</tr>";
	while ($ligne = mysqli_fetch_row($res)) {
			if ($ligne[3] == 'F'){
				$sexe = "feminin";
			}else{
				$sexe = "masculin";
			}
			echo "<tr>
				<td>$ligne[0]</td>
				<td>$ligne[1]</td>
				<td>$ligne[2]</td>
				<td> $sexe </td>
				<td>$ligne[4]</td>
				<td>$ligne[5]</td>
				<td>$ligne[6]</td>
			</tr>";
	}
	echo "</table>";
	echo "</center>";
?>
