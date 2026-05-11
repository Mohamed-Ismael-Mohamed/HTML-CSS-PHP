<?php
session_start();
include('config.php');

if (!isset($_SESSION['nom'])) {
    header("Location: Page_autorisation.php");
    exit();
}

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    
    if ($table == 'details_commande') {
        $id_p = mysqli_real_escape_string($connexion, $_GET['id_p']);
        $id_c = mysqli_real_escape_string($connexion, $_GET['id_c']);
        $sql = "DELETE FROM details_commande WHERE id_produit = '$id_p' AND id_commande = '$id_c'";
    } else {
        $id = mysqli_real_escape_string($connexion, $_GET['id']);
        
        $res_cols = mysqli_query($connexion, "SHOW COLUMNS FROM $table");
        $pk = mysqli_fetch_row($res_cols)[0]; 
        
        $sql = "DELETE FROM $table WHERE $pk = '$id'";
    }

    if (mysqli_query($connexion, $sql)) {
        header("Location: interface_administrateur.php?table=$table&msg=sup_success");
    } else {
        $error = urlencode(mysqli_error($connexion));
        header("Location: interface_administrateur.php?table=$table&msg=error&detail=$error");
    }
    exit();
}
?>