<?php

$chaine = "a3b2c4";

$resultat = "";

for($i = 0; $i < strlen($chaine); $i = $i + 2)
{
    $lettre = $chaine[$i];
    $nombre = $chaine[$i + 1];

    for($j = 1; $j <= $nombre; $j++)
    {
        $resultat = $resultat . $lettre;
    }
}

echo $resultat;

?>