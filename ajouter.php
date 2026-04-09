<?php
session_start();
include('config.php');

if (!isset($_SESSION['nom'])) {
    header("Location: Page_autorisation.php");
    exit();
}

$table = isset($_GET['table']) ? $_GET['table'] : 'produit';

// 1. Récupération des colonnes
$colonnes = [];
$res_cols = mysqli_query($connexion, "SHOW COLUMNS FROM $table");
while ($col = mysqli_fetch_assoc($res_cols)) {
    if ($col['Extra'] !== 'auto_increment') {
        $colonnes[] = [
            'nom' => $col['Field'],
            'type' => $col['Type']
        ];
    }
}

// 2. Traitement de l'insertion
if (isset($_POST['btn_enregistrer'])) {
    $champs = [];
    $valeurs = [];
    foreach ($_POST as $key => $val) {
        if ($key !== 'btn_enregistrer') {
            $champs[] = $key;
            $clean_val = mysqli_real_escape_string($connexion, $val);
            $valeurs[] = "'$clean_val'";
        }
    }
    $sql = "INSERT INTO $table (" . implode(',', $champs) . ") VALUES (" . implode(',', $valeurs) . ")";
    if (mysqli_query($connexion, $sql)) {
        header("Location: interface_administrateur.php?table=$table&msg=success");
        exit();
    } else {
        $erreur = "Erreur SQL : " . mysqli_error($connexion);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter - <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-top: 5px solid #00adef; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-save { width: 100%; background: #009345; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 1em; }
        .btn-save:hover { background: #007d3a; }
    </style>
</head>
<body>

<div class="form-container">
    <h2><i class="fas fa-plus-circle"></i> Nouveau : <?php echo ucfirst($table); ?></h2>
    <hr style="border:0; border-top:1px solid #eee; margin: 20px 0;">

    <?php if(isset($erreur)) echo "<div style='color:red; margin-bottom:15px;'>$erreur</div>"; ?>

    <form method="POST">
        <?php foreach ($colonnes as $c): ?>
            <div class="form-group">
                <label><?php echo str_replace('_', ' ', $c['nom']); ?></label>

                <?php 
                // DETECTION DES CLÉS ÉTRANGÈRES (id_...)
                if (substr($c['nom'], 0, 3) === 'id_') {
                    // On détermine la table cible (ex: id_categorie -> table categorie)
                    $table_cible = str_replace('id_', '', $c['nom']);
                    echo "<select name='{$c['nom']}' class='form-control' required>";
                    echo "<option value=''>-- Choisir --</option>";
                    
                    $res_fk = mysqli_query($connexion, "SELECT * FROM $table_cible");
                    while($row_fk = mysqli_fetch_row($res_fk)) {
                        // On affiche l'ID et la 2ème colonne (souvent le nom)
                        $label = isset($row_fk[1]) ? " - " . $row_fk[1] : "";
                        echo "<option value='{$row_fk[0]}'>ID: {$row_fk[0]} $label</option>";
                    }
                    echo "</select>";
                } 
                // SINON : CHAMP CLASSIQUE
                else {
                    $type = "text";
                    if(strpos($c['type'], 'int') !== false || strpos($c['type'], 'decimal') !== false) $type = "number";
                    if(strpos($c['nom'], 'date') !== false) $type = "date";
                    
                    echo "<input type='$type' name='{$c['nom']}' class='form-control' required step='any'>";
                }
                ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" name="btn_enregistrer" class="btn-save">
            <i class="fas fa-save"></i> ENREGISTRER DANS LA BASE
        </button>
        <a href="interface_administrateur.php?table=<?php echo $table; ?>" style="display:block; text-align:center; margin-top:15px; color:#999; text-decoration:none;">Annuler</a>
    </form>
</div>

</body>
</html>