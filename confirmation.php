<?php
session_start();
$host = 'localhost'; $dbname = 'projet_web'; $user = 'root'; $pass = '';

if (!isset($_SESSION['id_client']) || empty($_SESSION['panier'])) {
    header("Location: choix_produit.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->beginTransaction();

    // 1. TABLE : commande
    $stmt = $pdo->prepare("INSERT INTO commande (date_commande, id_client, statut_commande) VALUES (NOW(), ?, 'En attente')");
    $stmt->execute([$_SESSION['id_client']]);
    $id_commande = $pdo->lastInsertId();

    $total_panier = 0;
    $liste_produits = []; // Pour l'affichage sur la facture

    // 2. TABLE : details_commande
    foreach ($_SESSION['panier'] as $id_p => $qte) {
        $stmtP = $pdo->prepare("SELECT prix, nom_produit FROM produit WHERE id_produit = ?");
        $stmtP->execute([$id_p]);
        $prod = $stmtP->fetch();
        
        $sous_total = $prod['prix'] * $qte;
        $total_panier += $sous_total;

        // On stocke pour l'affichage HTML plus bas
        $liste_produits[] = [
            'nom' => $prod['nom_produit'],
            'prix' => $prod['prix'],
            'qte' => $qte,
            'st' => $sous_total
        ];

        $stmtD = $pdo->prepare("INSERT INTO details_commande (id_commande, id_produit, prix_unitaire, quantite) VALUES (?, ?, ?, ?)");
        $stmtD->execute([$id_commande, $id_p, $prod['prix'], $qte]);
    }

    // 3. TABLE : facture
    $stmtF = $pdo->prepare("INSERT INTO facture (date_facture, id_commande, montant_total_facture) VALUES (NOW(), ?, ?)");
    $stmtF->execute([$id_commande, $total_panier]);
    $id_facture = $pdo->lastInsertId();

    $pdo->commit();

    // --- CORRECTION RACINE : ON STOCKA TOUT EN SESSION ---
    $_SESSION['temp_id_facture'] = $id_facture;
    $_SESSION['temp_id_commande'] = $id_commande; // Cette ligne manquait !
    $_SESSION['temp_total'] = $total_panier;

} catch (Exception $e) {
    if(isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    die("Erreur BDD : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #<?php echo $id_facture; ?> | DSS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&family=Montserrat:wght@400;700;900&display=swap');
        body { background: #0a0a0a; color: #fff; font-family: 'Montserrat', sans-serif; text-align: center; padding: 50px; }
        .invoice-box { background: #fff; color: #000; padding: 40px; border-radius: 10px; display: inline-block; text-align: left; width: 100%; max-width: 700px; box-shadow: 0 0 20px rgba(0,212,255,0.2); }
        h1 { font-family: 'Audiowide'; color: #00d4ff; text-align: center; margin-bottom: 30px; border-bottom: 2px solid #00d4ff; padding-bottom: 10px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .item-row { font-size: 0.9rem; color: #555; }
        .total-row { font-size: 1.8rem; color: #d32f2f; font-weight: 900; margin-top: 30px; border: none; }
        .btns-container { margin-top: 40px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
        .btn { padding: 15px 30px; border-radius: 50px; text-decoration: none; font-family: 'Audiowide'; transition: 0.3s; cursor: pointer; border: none; display: flex; align-items: center; gap: 10px; font-size: 0.9rem; }
        .btn-pay { background: #00d4ff; color: #000; }
        .btn-print { background: #6c757d; color: #fff; }
        .btn-cancel { background: transparent; color: #ff4b2b; border: 1px solid #ff4b2b; }
        @media print {
            body { background: #fff; padding: 0; }
            .btns-container { display: none; }
            .invoice-box { box-shadow: none; border: 1px solid #000; width: 100%; }
            h1 { color: #000; border-bottom: 2px solid #000; }
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <h1>DSS <span style="color: #000;">DIGITAL SHOP</span></h1>
        <div style="text-align: right; margin-bottom: 20px;">
            <p><b>Date :</b> <?php echo date('d/m/Y H:i'); ?></p>
            <p><b>Facture N° :</b> #<?php echo $id_facture; ?></p>
        </div>

        <div class="row"><span>Client :</span> <b>
            <?php 
                $nom_complet = (isset($_SESSION['client_prenom']) ? $_SESSION['client_prenom'] . ' ' : '') . $_SESSION['client_nom'];
                echo strtoupper($nom_complet); 
            ?>
        </b></div>
        <div class="row"><span>Référence Commande :</span> <b>#<?php echo $id_commande; ?></b></div>
        <div class="row"><span>Statut :</span> <b style="color: orange;">EN ATTENTE DE PAIEMENT</b></div>
        
        <br>
        <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px;">DÉTAILS DES ACHATS</h3>
        <?php foreach($liste_produits as $p): ?>
            <div class="row item-row">
                <span><?php echo $p['nom']; ?> (x<?php echo $p['qte']; ?>)</span>
                <span><?php echo number_format($p['st'], 0, '.', ' '); ?> DJF</span>
            </div>
        <?php endforeach; ?>

        <div class="row total-row">
            <span>TOTAL À RÉGLER :</span>
            <span><?php echo number_format($total_panier, 0, '.', ' '); ?> DJF</span>
        </div>
    </div>

    <div class="btns-container">
        <button onclick="window.print()" class="btn btn-print">
            <i class="fas fa-print"></i> IMPRIMER
        </button>
        <a href="panier.php" class="btn btn-cancel">ANNULER</a>
        <a href="paiement.php" class="btn btn-pay">
            PASSER AU PAIEMENT <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</body>
</html>