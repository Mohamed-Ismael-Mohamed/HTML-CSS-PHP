<?php
session_start();
include('config.php');

if (!isset($_SESSION['nom'])) {
    header("Location: Page_autorisation.php");
    exit();
}

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    
    // 1. GESTION DES PARAMÈTRES SELON LA TABLE
    if ($table == 'details_commande') {
        $id_p = mysqli_real_escape_string($connexion, $_GET['id_p']);
        $id_c = mysqli_real_escape_string($connexion, $_GET['id_c']);
        $sql = "DELETE FROM details_commande WHERE id_produit = '$id_p' AND id_commande = '$id_c'";
    } else {
        $id = mysqli_real_escape_string($connexion, $_GET['id']);
        
        // Trouver dynamiquement le nom de la clé primaire
        $res_cols = mysqli_query($connexion, "SHOW COLUMNS FROM $table");
        $pk = mysqli_fetch_row($res_cols)[0]; 
        
        $sql = "DELETE FROM $table WHERE $pk = '$id'";
    }

    // 2. EXÉCUTION ET REDIRECTION
    if (mysqli_query($connexion, $sql)) {
        header("Location: interface_administrateur.php?table=$table&msg=sup_success");
    } else {
        // Si erreur (ex: contrainte de clé étrangère), on renvoie l'erreur
        $error = urlencode(mysqli_error($connexion));
        header("Location: interface_administrateur.php?table=$table&msg=error&detail=$error");
    }
    exit();
}
?>