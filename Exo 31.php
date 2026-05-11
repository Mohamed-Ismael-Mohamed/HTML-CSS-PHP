<?php

$tab1 = [1,3,5];
$tab2 = [2,4,6];

$resultat = [];

for($i = 0; $i < count($tab1); $i++)
{
    $resultat[] = $tab1[$i];
}

for($i = 0; $i < count($tab2); $i++)
{
    $resultat[] = $tab2[$i];
}

for($i = 0; $i < count($resultat) - 1; $i++)
{
    for($j = $i + 1; $j < count($resultat); $j++)
    {
        if($resultat[$i] > $resultat[$j])
        {
            $temp = $resultat[$i];
            $resultat[$i] = $resultat[$j];
            $resultat[$j] = $temp;
        }
    }
}

print_r($resultat);

?>