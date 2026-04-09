<?php
session_start();

// 1. On vérifie si on a bien reçu un ID de produit
if (isset($_POST['id_produit'])) {
    $id_p = $_POST['id_produit'];

    // 2. Si le panier n'existe pas encore dans la session, on le crée
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // 3. On ajoute le produit au panier
    // Si le produit est déjà dans le panier, on augmente la quantité
    if (isset($_SESSION['panier'][$id_p])) {
        $_SESSION['panier'][$id_p]++; 
    } else {
        // Sinon, on l'ajoute avec une quantité de 1
        $_SESSION['panier'][$id_p] = 1;
    }
}

// 4. On redirige immédiatement vers le catalogue pour continuer les achats
header("Location: choix_produit.php?success=1");
exit();
?>