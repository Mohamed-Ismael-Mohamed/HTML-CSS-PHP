<?php

function palindrome($mot)
{
    $inverse = "";

    for($i = strlen($mot) - 1; $i >= 0; $i--)
    {
        $inverse = $inverse . $mot[$i];
    }

    if($mot == $inverse)
    {
        return "Vrai";
    }
    else
    {
        return "Faux";
    }
}

echo palindrome("radar");

?>