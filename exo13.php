<?php

function factorielle($n)
{
    $fact = 1;

    for($i = 1; $i <= $n; $i++)
    {
        $fact = $fact * $i;
    }

    return $fact;
}

echo factorielle(5);

?>