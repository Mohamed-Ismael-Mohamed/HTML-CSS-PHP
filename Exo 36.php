<?php

$phrase = "Bonjour tout le monde";

$compteur = 1;

for($i = 0; $i < strlen($phrase); $i++)
{
    if($phrase[$i] == " ")
    {
        $compteur++;
    }
}

echo "Nombre de mots : " . $compteur;

?>