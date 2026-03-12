<?php
	$tab = array(1,2,-3,4,7);
	$pos=0;
	$min=$tab[0];
	$i=0;
	while ($i<count($tab)) {
		if($tab[$i]<$min){
			$min = $tab[$i];
			$pos = $i;
		}
		$i++;
	}
	echo "valeur minimale est $min à la position $pos";
?>