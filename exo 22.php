<?php

$tab = [4, 8, 2, 9, 1];

$valeur = 9;

$trouve = false;

for($i = 0; $i < count($tab); $i++)
{
    if($tab[$i] == $valeur)
    {
        $trouve = true;
    }
}

if($trouve == true)
{
    echo "Existe";
}
else
{
    echo "N'existe pas";
}

?>