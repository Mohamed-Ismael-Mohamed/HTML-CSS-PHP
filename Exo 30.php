<?php

$etudiants = [
    "Ali" => 15,
    "Sara" => 18,
    "Mohamed" => 12
];

$somme = 0;

$meilleurNom = "";
$meilleureNote = 0;

foreach($etudiants as $nom => $note)
{
    echo $nom . " : " . $note . "<br>";

    $somme = $somme + $note;

    if($note > $meilleureNote)
    {
        $meilleureNote = $note;
        $meilleurNom = $nom;
    }
}

$moyenne = $somme / count($etudiants);

echo "<br>";
echo "Moyenne : " . $moyenne . "<br>";

echo "Meilleur etudiant : " . $meilleurNom . "<br><br>";

foreach($etudiants as $nom => $note)
{
    if($note >= 10)
    {
        echo $nom . " admis<br>";
    }
    else
    {
        echo $nom . " non admis<br>";
    }
}

?>