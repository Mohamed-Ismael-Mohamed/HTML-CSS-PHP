<?php

$chaine = "bonjour";

$inverse = "";

for($i = strlen($chaine) - 1; $i >= 0; $i--)
{
    $inverse = $inverse . $chaine[$i];
}

echo $inverse;

?>