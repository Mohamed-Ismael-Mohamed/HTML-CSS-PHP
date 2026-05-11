<?php

$n = 17;

$premier = true;

if($n <= 1)
{
    $premier = false;
}

for($i = 2; $i < $n; $i++)
{
    if($n % $i == 0)
    {
        $premier = false;
    }
}

if($premier == true)
{
    echo "Premier";
}
else
{
    echo "Non premier";
}

?>