<?php
    $tab = array("foobar", "te", "test", "te");
    $cpt = 0;

    for ($i = 0; $i < count($tab); $i++) { 
        // On vérifie si "t" est contenu dans la chaîne
        if (str_contains($tab[$i], "t")) {
            $cpt++;
        }
    }
    echo "Le mot contient la lettre t dans $cpt éléments du tableau !";
?>