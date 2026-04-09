<?php
session_start();
include('config.php');

if (!isset($_SESSION['nom'])) {
    header("Location: Page_autorisation.php");
    exit();
}

$table = isset($_GET['table']) ? $_GET['table'] : 'produit';

// 1. Récupération des noms de colonnes pour l'en-tête du tableau
$colonnes = [];
$res_cols = mysqli_query($connexion, "SHOW COLUMNS FROM $table");
while ($col = mysqli_fetch_assoc($res_cols)) {
    $colonnes[] = $col['Field'];
}

// 2. Récupération de toutes les données de la table
$resultat = mysqli_query($connexion, "SELECT * FROM $table");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Impression - <?php echo ucfirst($table); ?></title>
    <!-- On n'oublie pas le lien FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 40px; color: #333; background: white; }
        
        .header-print { 
            text-align: center; 
            border-bottom: 3px double #333; 
            margin-bottom: 30px; 
            padding-bottom: 20px;
        }
        
        .logo-print { font-weight: bold; font-size: 24px; color: #000; margin-bottom: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 10px; text-align: left; font-size: 12px; }
        th { background: #f2f2f2; text-transform: uppercase; }
        
        /* Zone des boutons */
        .actions-print { margin-bottom: 30px; display: flex; gap: 10px; }
        
        .btn-print { 
            background: #009345; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn-back { background: #666; }
        .btn-print:hover { opacity: 0.9; }

        /* Style spécifique pour l'impression papier */
        @media print { 
            .actions-print { display: none !important; } 
            body { padding: 0; }
            th { background: #eee !important; color: black !important; }
        }
    </style>
</head>
<body>

    <div class="header-print">
        <div class="logo-print">DJIBOUTI SPORT SHOP</div>
        <h2 style="margin: 5px 0;">RAPPORT D'INVENTAIRE : <?php echo strtoupper($table); ?>S</h2>
        <p style="font-size: 14px; color: #666;">
            Généré le : <b><?php echo date('d/m/Y à H:i'); ?></b><br>
            Responsable : <b><?php echo htmlspecialchars($_SESSION['nom']); ?></b>
        </p>
    </div>

    <!-- Zone des boutons avec icônes -->
    <div class="actions-print">
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> IMPRIMER CE RAPPORT
        </button>
        
        <a href="interface_administrateur.php?table=<?php echo $table; ?>" class="btn-print btn-back">
            <i class="fas fa-arrow-left"></i> RETOUR
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <?php foreach ($colonnes as $col): ?>
                    <th><?php echo str_replace('_', ' ', $col); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($resultat) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($resultat)): ?>
                    <tr>
                        <?php foreach ($row as $v): ?>
                            <td><?php echo htmlspecialchars($v); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="<?php echo count($colonnes); ?>" style="text-align:center;">Aucune donnée disponible.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right; font-size: 12px;">
        <p>Signature et Cachet : _________________________</p>
    </div>

</body>
</html>