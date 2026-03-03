<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php
	$valeur1 =$_POST['val1'];
	$valeur2 =$_POST['val2'];
	$operation =$_POST['operation'];
	if ($operation == '+') {
		echo "$valeur1 + $valeur2 = ",($valeur1+$valeur2);
	}elseif ($operation == '-') {
		echo "$valeur1 - $valeur2 = ",($valeur1-$valeur2);
	}elseif ($operation == '*') {
		echo "$valeur1 * $valeur2 = ",($valeur1*$valeur2);
	}else{
		echo "$valeur1 / $valeur2 = ",($valeur1/$valeur2);
	}
	?>
</body>
</html>