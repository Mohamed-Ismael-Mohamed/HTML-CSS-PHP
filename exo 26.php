<?php

$tab = [5, 8, 1, 3, 9];

for($i = 0; $i < count($tab) - 1; $i++)
{
    $min = $i;

    for($j = $i + 1; $j < count($tab); $j++)
    {
        if($tab[$j] < $tab[$min])
        {
            $min = $j;
        }
    }

    $temp = $tab[$i];
    $tab[$i] = $tab[$min];
    $tab[$min] = $temp;
}

print_r($tab);

?>