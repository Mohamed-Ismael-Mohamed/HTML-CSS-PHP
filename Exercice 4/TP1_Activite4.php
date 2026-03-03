<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php
	$value = $_POST['val1'];
	$somme=0;
	for ($i=0;$i<=$value;$i++) { 
		echo "$i + ";
		$somme+=$i;
	}
	echo "= $somme";
	?>
</body>
</html>