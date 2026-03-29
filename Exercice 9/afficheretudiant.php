<?php
$connexion = mysqli_connect("localhost","root","","gestion_etudiant");
$res = mysqli_query($connexion, "select * from etudiants");
while($ligne = mysqli_fetch_row($res)){
if ($ligne[3] == 'F') {
	echo "$ligne[0], $ligne[1], $ligne[2], feminin, $ligne[4], $ligne[5], $ligne[6] <br><br>";
}else{
echo "$ligne[0], $ligne[1], $ligne[2], masculin, $ligne[4], $ligne[5], $ligne[6] <br><br>";	
}
}
?>