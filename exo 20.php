<?php

$chaine = "aaabbccccdd";

$resultat = "";

$compteur = 1;

for($i = 0; $i < strlen($chaine); $i++)
{
    if($i < strlen($chaine) - 1 && $chaine[$i] == $chaine[$i + 1])
    {
        $compteur++;
    }
    else
    {
        $resultat = $resultat . $chaine[$i] . $compteur;
        $compteur = 1;
    }
}

echo $resultat;

?>