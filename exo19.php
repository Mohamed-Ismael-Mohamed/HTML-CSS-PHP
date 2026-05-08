<?php

$tab = [12, 7, 45, 3, 29];

$max = $tab[0];

for($i = 1; $i < count($tab); $i++)
{
    if($tab[$i] > $max)
    {
        $max = $tab[$i];
    }
}

echo "Le plus grand nombre est : " . $max;

?>