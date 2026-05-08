<?php

$tab = [10, 20, 30, 40];

$somme = 0;

for($i = 0; $i < count($tab); $i++)
{
    $somme = $somme + $tab[$i];
}

echo "Somme = " . $somme;

?>
