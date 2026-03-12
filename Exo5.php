<?php
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    
    // Correction de la faute de frappe ($num1 au lieu de $nume1)
    $somme = $num1 + $num2;
    
    echo "Somme de $num1 et $num2 = " . $somme;
?>