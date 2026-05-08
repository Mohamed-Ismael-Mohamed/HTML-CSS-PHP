<?php

$chaine = "Bonjour";

$voyelles = 0;

for($i = 0; $i < strlen($chaine); $i++)
{
    $lettre = strtolower($chaine[$i]);

    if($lettre == 'a' || $lettre == 'e' || $lettre == 'i' || $lettre == 'o' || $lettre == 'u' || $lettre == 'y')
    {
        $voyelles++;
    }
}

echo "Nombre de voyelles : " . $voyelles;

?>