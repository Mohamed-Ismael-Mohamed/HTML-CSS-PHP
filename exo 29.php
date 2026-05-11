<?php

$tab = [12, 7, 25, 40, 18];

$max1 = $tab[0];
$max2 = $tab[0];

for($i = 1; $i < count($tab); $i++)
{
    if($tab[$i] > $max1)
    {
        $max2 = $max1;
        $max1 = $tab[$i];
    }
    else
    {
        if($tab[$i] > $max2 && $tab[$i] != $max1)
        {
            $max2 = $tab[$i];
        }
    }
}

echo $max2;

?>