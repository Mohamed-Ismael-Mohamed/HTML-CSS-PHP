<?php
	$tab = array(1,12,0,3);
	echo " somme des 4 elements du tableau : ",($tab[0]+$tab[1]+$tab[2]+$tab[3]),"<br>";
	function retourne_Somme(){
		global $tab;
		$s=0;
		foreach($tab as $element){
			$s+=$element;
		}
		echo "Somme : $s";
	}
	retourne_Somme();
?>