<?php

function moyenne($tab)
{
    $somme = 0;

    for($i = 0; $i < count($tab); $i++)
    {
        $somme = $somme + $tab[$i];
    }

    return $somme / count($tab);
}

$notes = [12, 15, 18, 10];

echo moyenne($notes);

?>