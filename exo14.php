<?php

$tab = [5, 2, 8, 1, 9];

for($i = 0; $i < count($tab) - 1; $i++)
{
    for($j = 0; $j < count($tab) - $i - 1; $j++)
    {
        if($tab[$j] > $tab[$j + 1])
        {
            $temp = $tab[$j];
            $tab[$j] = $tab[$j + 1];
            $tab[$j + 1] = $temp;
        }
    }
}

for($i = 0; $i < count($tab); $i++)
{
    echo $tab[$i] . " ";
}

?>