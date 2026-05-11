<?php

$tab = [1,2,3,4,5];

$dernier = $tab[count($tab) - 1];

for($i = count($tab) - 1; $i > 0; $i--)
{
    $tab[$i] = $tab[$i - 1];
}

$tab[0] = $dernier;

print_r($tab);

?>