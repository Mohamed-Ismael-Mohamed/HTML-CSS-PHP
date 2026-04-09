<?php
session_start();
include('config.php'); 

if (!isset($_SESSION['nom'])) {
    header("Location: Page_autorisation.php");
    exit();
}

// 1. DÉTECTER LA TABLE ET LA RECHERCHE
$table = isset($_GET['table']) ? $_GET['table'] : 'produit';
$search = isset($_GET['search']) ? mysqli_real_escape_string($connexion, $_GET['search']) : '';

// 2. FONCTION POUR LES COMPTEURS RÉELS
function getCount($t) {
    global $connexion;
    $res = mysqli_query($connexion, "SELECT COUNT(*) FROM $t");
    return ($res) ? mysqli_fetch_row($res)[0] : 0;
}

$counts = [
    'categorie'        => getCount('categorie'),
    'client'           => getCount('client'),
    'produit'          => getCount('produit'),
    'commande'         => getCount('commande'),
    'details_commande' => getCount('details_commande'),
    'facture'          => getCount('facture'),
    'paiement'         => getCount('paiement')
];

// 3. REQUÊTE SQL DYNAMIQUE
$query = "SELECT * FROM $table";
if (!empty($search)) {
    $res_col = mysqli_query($connexion, "SHOW COLUMNS FROM $table");
    mysqli_fetch_row($res_col); // Saute l'ID
    $col_info = mysqli_fetch_row($res_col); // Prend la 2ème colonne
    if ($col_info) {
        $nom_colonne = $col_info[0];
        $query .= " WHERE $nom_colonne LIKE '%$search%'";
    }
}
$resultat = mysqli_query($connexion, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>DSS ADMIN - Gestion</title>
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <link rel="stylesheet" href="style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <h2>DSS ADMIN</h2>
        <details open>
            <summary>
                <div class="burger-icon"><span></span><span></span><span></span></div>
                EXPLOITATION DES DONNÉES
            </summary>
            <div class="menu-items">
                <a href="?table=produit" class="<?php echo $table=='produit'?'active':''; ?>"><i class="fas fa-box"></i> Produits</a>
                <a href="?table=categorie" class="<?php echo $table=='categorie'?'active':''; ?>"><i class="fas fa-list"></i> Catégories</a>
                <a href="?table=client" class="<?php echo $table=='client'?'active':''; ?>"><i class="fas fa-users"></i> Clients</a>
                <a href="?table=commande" class="<?php echo $table=='commande'?'active':''; ?>"><i class="fas fa-shopping-cart"></i> Commandes</a>
                <a href="?table=details_commande" class="<?php echo $table=='details_commande'?'active':''; ?>"><i class="fas fa-info-circle"></i> Détails Commandes</a>
                <a href="?table=facture" class="<?php echo $table=='facture'?'active':''; ?>"><i class="fas fa-file-invoice"></i> Factures</a>
                <a href="?table=paiement" class="<?php echo $table=='paiement'?'active':''; ?>"><i class="fas fa-credit-card"></i> Paiements</a>
            </div>
        </details>
        <div class="logout-container">
            <a href="deconnexion.php" class="deconnexion"><i class="fas fa-power-off"></i> DÉCONNEXION</a>
        </div>
    </nav>

    <div class="main-content">
        <header>
            <div class="logo-area">
                <img src="Logo_marque.png" height="35">
                <h1>DJIBOUTI SPORT SHOP</h1>
            </div>
            <div class="admin-badge">
                <i class="fas fa-user-circle"></i> <b><?php echo htmlspecialchars($_SESSION['nom']); ?></b>
            </div>
        </header>

        <div class="container">
            <h2 style="margin:0;">Tableau de Bord</h2>
            <p style="color: #999; margin-bottom: 20px;">Gestion en temps réel</p>

            <!-- ZONE DES MESSAGES DE NOTIFICATION -->
            <?php if(isset($_GET['msg'])): ?>
                <?php if($_GET['msg'] == 'mod_success'): ?>
                    <div style="background: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #17a2b8;">
                        <i class="fas fa-info-circle"></i> MODIFICATION réussie !
                    </div>
                <?php elseif($_GET['msg'] == 'success'): ?>
                    <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #28a745;">
                        <i class="fas fa-check-circle"></i> Ajout réussi !
                    </div>
                <?php elseif($_GET['msg'] == 'sup_success'): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #dc3545;">
                        <i class="fas fa-trash-alt"></i> SUPPRESSION réussie !
                    </div>
                <?php elseif($_GET['msg'] == 'error'): ?>
                    <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #ffc107;">
                        <i class="fas fa-exclamation-triangle"></i> Erreur : Impossible de supprimer (Donnée liée à une autre table).
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="dashboard-grid">
                <div class="stats-column">
                    <p style="font-size: 0.8em; color: #777; font-weight: bold; margin-bottom: 5px;">IMPRIMER :</p>
                    <?php 
                    $icons = [
                        'categorie' => ['f' => 'folder', 'c' => '#00adef'],
                        'client' => ['f' => 'user', 'c' => '#555'],
                        'produit' => ['f' => 'shoe-prints', 'c' => '#e11c24'],
                        'commande' => ['f' => 'shopping-cart', 'c' => '#009345'],
                        'details_commande' => ['f' => 'info-circle', 'c' => '#17a2b8'],
                        'facture' => ['f' => 'file-alt', 'c' => '#6f42c1'],
                        'paiement' => ['f' => 'credit-card', 'c' => '#fd7e14']
                    ];
                    foreach($counts as $t => $nb): ?>
                        <a href="imprimer.php?table=<?php echo $t; ?>" class="stat-link">
                            <div class="stat-card" style="border-left-color: <?php echo $icons[$t]['c']; ?>;">
                                <div><h4><?php echo ucfirst(str_replace('_', ' ', $t)); ?>s</h4><p><?php echo $nb; ?></p></div>
                                <i class="fas fa-<?php echo $icons[$t]['f']; ?>"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="table-column">
                    <div class="table-header">
                        <h3 style="margin:0;">Liste des <?php echo ucfirst(str_replace('_', ' ', $table)); ?>s</h3>
                        <form method="GET" style="display:flex; gap:10px;">
                            <input type="hidden" name="table" value="<?php echo $table; ?>">
                            <input type="text" name="search" class="search-box" placeholder="Rechercher..." value="<?php echo htmlspecialchars($search); ?>">
                            <a href="ajouter.php?table=<?php echo $table; ?>" class="btn-add">+ Ajouter</a>
                        </form>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID / Réf</th>
                                <th>Informations</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($resultat && mysqli_num_rows($resultat) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($resultat)): 
                                    $vals = array_values($row); 
                                    
                                    // PRÉPARATION DU LIEN DYNAMIQUE (Modif/Suppr)
                                    if($table == 'details_commande'){
                                        $link_params = "table=$table&id_p=".$row['id_produit']."&id_c=".$row['id_commande'];
                                    } else {
                                        $link_params = "table=$table&id=".$vals[0];
                                    }
                                ?>
                                    <tr>
                                        <td>#<?php echo $vals[0]; ?></td>
                                        <td>
                                            <b><?php echo htmlspecialchars($vals[1] ?? ''); ?></b>
                                            <span style="color:#999; font-size:0.85em; margin-left:10px;">
                                                <?php echo htmlspecialchars($vals[2] ?? ''); ?>
                                            </span>
                                        </td>
                                        <td class="actions" style="text-align:right;">
                                            <!-- BOUTON MODIFIER -->
                                            <a href="modifier.php?<?php echo $link_params; ?>" class="btn-e">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <!-- BOUTON SUPPRIMER -->
                                            <a href="supprimer.php?<?php echo $link_params; ?>" class="btn-s" onclick="return confirm('Voulez-vous vraiment supprimer cet élément ?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" style="text-align:center; padding:30px;">Aucune donnée.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>