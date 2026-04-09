<?php
session_start();
include('config.php');

if (!isset($_SESSION['nom'])) {
    header("Location: Page_autorisation.php");
    exit();
}

$table = $_GET['table'];
$msg = "";

// 1. RÉCUPÉRATION DU NOM DE LA CLÉ PRIMAIRE
$res_cols = mysqli_query($connexion, "SHOW COLUMNS FROM $table");
$colonnes = [];
$pk = "";
while ($col = mysqli_fetch_assoc($res_cols)) {
    $colonnes[] = $col['Field'];
    if ($col['Key'] == 'PRI' && empty($pk)) {
        $pk = $col['Field'];
    }
}

// 2. RÉCUPÉRATION DES DONNÉES ACTUELLES
if ($table == 'details_commande') {
    $id_p = $_GET['id_p'];
    $id_c = $_GET['id_c'];
    $sql = "SELECT * FROM details_commande WHERE id_produit='$id_p' AND id_commande='$id_c'";
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM $table WHERE $pk='$id'";
}
$res = mysqli_query($connexion, $sql);
$donnees = mysqli_fetch_assoc($res);

// 3. TRAITEMENT DE LA MISE À JOUR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $set_query = [];
    foreach ($_POST as $colonne => $valeur) {
        $val_esc = mysqli_real_escape_string($connexion, $valeur);
        $set_query[] = "$colonne = '$val_esc'";
    }
    $sql_part = implode(', ', $set_query);

    if ($table == 'details_commande') {
        $update = "UPDATE details_commande SET $sql_part WHERE id_produit='$id_p' AND id_commande='$id_c'";
    } else {
        $update = "UPDATE $table SET $sql_part WHERE $pk='$id'";
    }

    if (mysqli_query($connexion, $update)) {
        // CHANGEMENT DU MESSAGE ICI
        header("Location: interface_administrateur.php?table=$table&msg=mod_success");
        exit();
    } else {
        $msg = "Erreur : " . mysqli_error($connexion);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>DSS ADMIN - Modification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --gradient-dss: linear-gradient(135deg, #00adef 0%, #009345 100%);
            --bleu-dss: #00adef;
        }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        
        .form-card { 
            background: white; 
            width: 100%; 
            max-width: 500px; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-top: 5px solid var(--bleu-dss);
        }

        h2 { text-align: center; color: #333; margin-bottom: 30px; font-size: 1.5em; }
        h2 i { color: var(--bleu-dss); margin-right: 10px; }

        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #666; font-size: 0.9em; text-transform: uppercase; }
        
        input, select { 
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            font-size: 1em;
            transition: 0.3s;
            outline: none;
        }

        input:focus, select:focus { border-color: var(--bleu-dss); box-shadow: 0 0 0 3px rgba(0, 173, 239, 0.1); }
        input[readonly] { background-color: #f8f9fa; color: #aaa; cursor: not-allowed; }

        .btn-submit { 
            background: var(--gradient-dss); 
            color: white; 
            border: none; 
            padding: 15px; 
            width: 100%; 
            border-radius: 8px; 
            font-weight: bold; 
            font-size: 1em; 
            cursor: pointer; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            gap: 10px;
            transition: 0.3s;
        }

        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 147, 69, 0.3); }

        .btn-cancel { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #999; 
            text-decoration: none; 
            font-size: 0.9em; 
        }
        .btn-cancel:hover { color: #e11c24; }
    </style>
</head>
<body>

    <div class="form-card">
        <h2><i class="fas fa-edit"></i> Modifier <?php echo ucfirst(str_replace('_', ' ', $table)); ?></h2>

        <form method="POST">
            <?php 
            foreach ($donnees as $colonne => $valeur): 
                $is_readonly = ($colonne == $pk || $colonne == 'id_produit' || $colonne == 'id_commande');
            ?>
                <div class="form-group">
                    <label><?php echo str_replace('_', ' ', $colonne); ?></label>
                    
                    <?php 
                    // LOGIQUE DES LISTES DÉROULANTES POUR CLÉS ÉTRANGÈRES
                    if ($colonne == 'id_categorie'): ?>
                        <select name="id_categorie">
                            <?php 
                            $cats = mysqli_query($connexion, "SELECT * FROM categorie");
                            while($c = mysqli_fetch_assoc($cats)) {
                                $sel = ($c['id_categorie'] == $valeur) ? "selected" : "";
                                echo "<option value='".$c['id_categorie']."' $sel>".$c['nom_categorie']."</option>";
                            }
                            ?>
                        </select>

                    <?php elseif ($colonne == 'id_client'): ?>
                        <select name="id_client">
                            <?php 
                            $cls = mysqli_query($connexion, "SELECT * FROM client");
                            while($cl = mysqli_fetch_assoc($cls)) {
                                $sel = ($cl['id_client'] == $valeur) ? "selected" : "";
                                echo "<option value='".$cl['id_client']."' $sel>".$cl['nom']." ".$cl['prenom']."</option>";
                            }
                            ?>
                        </select>

                    <?php else: ?>
                        <input type="text" name="<?php echo $colonne; ?>" 
                               value="<?php echo htmlspecialchars($valeur); ?>" 
                               <?php echo $is_readonly ? 'readonly' : 'required'; ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> ENREGISTRER LES MODIFICATIONS
            </button>
            
            <a href="interface_administrateur.php?table=<?php echo $table; ?>" class="btn-cancel">
                <i class="fas fa-times"></i> Annuler et retourner
            </a>
        </form>
    </div>

</body>
</html>