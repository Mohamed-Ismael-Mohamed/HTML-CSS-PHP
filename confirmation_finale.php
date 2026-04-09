<?php
session_start();
$host = 'localhost'; $dbname = 'projet_web'; $user = 'root'; $pass = '';

// Sécurité : Si on arrive ici sans passer par le formulaire de paiement
if (!isset($_POST['methode']) || !isset($_SESSION['temp_id_facture'])) {
    header("Location: choix_produit.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->beginTransaction();

    $id_fac = $_SESSION['temp_id_facture'];
    $id_com = $_SESSION['temp_id_commande'];
    $total = $_SESSION['temp_total'];
    $id_cli = $_SESSION['id_client'];
    $methode = $_POST['methode'];
    $details = $_POST['details_paiement'] ?? 'N/A';

    // 1. INSERTION DANS LA TABLE : paiement
    // On enregistre la trace de l'argent
    $stmtPay = $pdo->prepare("INSERT INTO paiement (date_paiement, id_client, id_facture, methode, montant_payee, statut_paiement) VALUES (NOW(), ?, ?, ?, ?, 'Confirmé')");
    $stmtPay->execute([$id_cli, $id_fac, $methode, $total]);

    // 2. MISE À JOUR DE LA TABLE : commande
    // On change le statut de 'En attente' à 'Payée'
    $stmtUpd = $pdo->prepare("UPDATE commande SET statut_commande = 'Payée' WHERE id_commande = ?");
    $stmtUpd->execute([$id_com]);

    $pdo->commit();

    // 3. NETTOYAGE : On vide le panier car l'achat est terminé
    unset($_SESSION['panier']);
    // On peut aussi enlever les variables temporaires
    unset($_SESSION['temp_id_facture'], $_SESSION['temp_total'], $_SESSION['temp_id_commande']);

} catch (Exception $e) {
    if(isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    die("Erreur lors de la validation : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Merci pour votre achat ! | DSS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&family=Montserrat:wght@400;700;900&display=swap');
        
        body { background: #0a0a0a; color: #fff; font-family: 'Montserrat', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        
        .success-card {
            background: #111;
            border: 2px solid #00d4ff;
            padding: 50px;
            border-radius: 30px;
            text-align: center;
            max-width: 600px;
            box-shadow: 0 0 80px rgba(0, 212, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .success-card::before {
            content: ""; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(0,212,255,0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .content { position: relative; z-index: 1; }

        .icon-box { 
            font-size: 5rem; color: #00d4ff; margin-bottom: 20px; 
            animation: bounceIn 1s ease;
        }

        h1 { font-family: 'Audiowide'; font-size: 2.2rem; margin-bottom: 10px; }
        p { color: #aaa; font-size: 1.1rem; line-height: 1.6; }
        
        .summary {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: left;
        }

        .summary div { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #222; padding-bottom: 5px; }
        .summary b { color: #00d4ff; }

        .final-btns { display: flex; gap: 20px; justify-content: center; margin-top: 40px; }
        
        .btn { padding: 15px 30px; border-radius: 50px; text-decoration: none; font-family: 'Audiowide'; transition: 0.3s; font-size: 0.9rem; }
        
        .btn-new { background: #00d4ff; color: #000; }
        .btn-new:hover { background: #fff; box-shadow: 0 0 20px #fff; }
        
        .btn-exit { border: 1px solid #ff4b2b; color: #ff4b2b; }
        .btn-exit:hover { background: #ff4b2b; color: #fff; }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); opacity: 1; }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="content">
        <div class="icon-box"><i class="fas fa-check-double"></i></div>
        <h1>TRANSACTION RÉUSSIE !</h1>
        <p>Félicitations <b><?php echo strtoupper($_SESSION['client_nom']); ?></b>, votre commande a été validée avec succès.</p>

        <div class="summary">
            <div><span>Référence Facture :</span> <b>#<?php echo $id_fac; ?></b></div>
            <div><span>Référence Commande :</span> <b>#<?php echo $id_com; ?></b></div>
            <div><span>Méthode utilisée :</span> <b><?php echo $methode; ?></b></div>
            <div><span>Montant débité :</span> <b style="font-size: 1.2rem;"><?php echo number_format($total, 0, '.', ' '); ?> DJF</b></div>
        </div>

        <p style="font-size: 0.9rem;">Un e-mail de confirmation vous a été envoyé (simulation).</p>

        <div class="final-btns">
            <a href="achat.php" class="btn btn-new">NOUVEL ACHAT</a>
            <a href="ACUEILL.html" class="btn btn-exit">QUITTER LE SHOP</a>
        </div>
    </div>
</div>

</body>
</html>