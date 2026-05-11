<?php

$nombre = rand(1, 100);

$essai = 50;

if($essai > $nombre)
{
    echo "Trop grand";
}
else
{
    if($essai < $nombre)
    {
        echo "Trop petit";
    }
    else
    {
        echo "Trouve";
    }
}

?>