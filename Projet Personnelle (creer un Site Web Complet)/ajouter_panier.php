<?php
session_start();

if (isset($_POST['id_produit'])) {
    $id_p = $_POST['id_produit'];

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }


    if (isset($_SESSION['panier'][$id_p])) {
        $_SESSION['panier'][$id_p]++; 
    } else {
        $_SESSION['panier'][$id_p] = 1;
    }
}

header("Location: choix_produit.php?success=1");
exit();
?>