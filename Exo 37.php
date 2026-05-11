<?php

$phrase = "Le developpement informatique est interessant";

$mots = explode(" ", $phrase);

$plusLong = $mots[0];

for($i = 1; $i < count($mots); $i++)
{
    if(strlen($mots[$i]) > strlen($plusLong))
    {
        $plusLong = $mots[$i];
    }
}

echo $plusLong;

?>