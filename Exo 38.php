<?php

$tab = ["chat", "ordinateur", "php", "clavier"];

for($i = 0; $i < count($tab) - 1; $i++)
{
    for($j = $i + 1; $j < count($tab); $j++)
    {
        if(strlen($tab[$i]) > strlen($tab[$j]))
        {
            $temp = $tab[$i];
            $tab[$i] = $tab[$j];
            $tab[$j] = $temp;
        }
    }
}

print_r($tab);

?>