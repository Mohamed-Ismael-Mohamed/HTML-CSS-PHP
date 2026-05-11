<?php

$mot = "banana";

$tab = [];

for($i = 0; $i < strlen($mot); $i++)
{
    $lettre = $mot[$i];

    if(isset($tab[$lettre]))
    {
        $tab[$lettre]++;
    }
    else
    {
        $tab[$lettre] = 1;
    }
}

foreach($tab as $cle => $valeur)
{
    echo $cle . " = " . $valeur . "<br>";
}

?>