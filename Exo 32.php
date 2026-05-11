<?php

$mdp = "Test1234";

$majuscule = false;
$chiffre = false;

if(strlen($mdp) >= 8)
{
    for($i = 0; $i < strlen($mdp); $i++)
    {
        if($mdp[$i] >= 'A' && $mdp[$i] <= 'Z')
        {
            $majuscule = true;
        }

        if($mdp[$i] >= '0' && $mdp[$i] <= '9')
        {
            $chiffre = true;
        }
    }

    if($majuscule == true && $chiffre == true)
    {
        echo "Mot de passe valide";
    }
    else
    {
        echo "Mot de passe invalide";
    }
}
else
{
    echo "Mot de passe invalide";
}

?>