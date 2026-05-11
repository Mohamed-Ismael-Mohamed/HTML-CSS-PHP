<?php

$tab = [1, 2, 2, 3, 4, 4, 5];

$resultat = [];

for($i = 0; $i < count($tab); $i++)
{
    $existe = false;

    for($j = 0; $j < count($resultat); $j++)
    {
        if($tab[$i] == $resultat[$j])
        {
            $existe = true;
        }
    }

    if($existe == false)
    {
        $resultat[] = $tab[$i];
    }
}

print_r($resultat);

?>