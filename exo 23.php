<?php

$matrice = [
    [1,2,3],
    [4,5,6],
    [7,8,9]
];

$somme = 0;

for($i = 0; $i < count($matrice); $i++)
{
    echo $matrice[$i][$i] . "<br>";

    for($j = 0; $j < count($matrice[$i]); $j++)
    {
        $somme = $somme + $matrice[$i][$j];
    }
}

echo "Somme = " . $somme;

?>