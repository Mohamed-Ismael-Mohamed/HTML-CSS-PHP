<?php

$n = 4;

for($i = 1; $i <= $n; $i++)
{
    for($j = 1; $j <= $n - $i; $j++)
    {
        echo "&nbsp;";
    }

    for($k = 1; $k <= ($i * 2) - 1; $k++)
    {
        echo "*";
    }

    echo "<br>";
}

?>