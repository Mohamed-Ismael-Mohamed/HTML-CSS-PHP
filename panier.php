<?php
session_start();

// 1. Connexion à la BDD
$host = 'localhost'; $dbname = 'projet_web'; $user = 'root'; $pass = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }

// 2. Gestion de la suppression d'un article
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
    $id_a_supprimer = $_GET['id'];
    unset($_SESSION['panier'][$id_a_supprimer]);
    header("Location: panier.php");
    exit();
}

$total_general = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier | DSS SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&family=Montserrat:wght@300;600;900&display=swap');
        
        body { background: #0a0a0a; color: #fff; font-family: 'Montserrat', sans-serif; margin: 0; }
        
        header {
            padding: 15px 5%;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 2px solid #00d4ff;
            background: rgba(0,0,0,0.9);
        }

        .container { padding: 50px 5%; }
        
        h1 { font-family: 'Audiowide'; color: #00d4ff; text-align: center; text-transform: uppercase; }

        .panier-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background: rgba(255,255,255,0.03);
            border-radius: 15px;
            overflow: hidden;
        }

        .panier-table th {
            background: #00d4ff;
            color: #000;
            padding: 15px;
            font-family: 'Audiowide';
            text-transform: uppercase;
        }

        .panier-table td {
            padding: 20px;
            border-bottom: 1px solid rgba(0,212,255,0.1);
            text-align: center;
        }

        .img-panier { width: 80px; height: 80px; object-fit: contain; background: #fff; border-radius: 8px; }

        /* Correction du bloc de droite (Total + Bouton) */
        .checkout-section {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            align-items: flex-end; /* Aligne tout à droite */
            gap: 25px; /* Espace entre le total et les boutons */
        }

        .total-container {
            text-align: right;
            padding: 20px 40px;
            border: 2px solid #00d4ff;
            border-radius: 15px;
            background: rgba(0, 212, 255, 0.05);
        }

        .total-price { font-size: 2.5rem; color: #00d4ff; font-weight: 900; }

        .actions { 
            width: 100%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .btn-continue { text-decoration: none; color: #fff; border: 1px solid #fff; padding: 15px 30px; border-radius: 50px; transition: 0.3s; font-family: 'Audiowide'; font-size: 0.8rem; }
        .btn-continue:hover { background: #fff; color: #000; }

        .btn-confirm { 
            text-decoration: none; 
            background: #00d4ff; 
            color: #000; 
            padding: 18px 45px; 
            border-radius: 50px; 
            font-family: 'Audiowide'; 
            font-weight: bold; 
            transition: 0.3s;
            box-shadow: 0 0 20px rgba(0,212,255,0.4);
            text-transform: uppercase;
        }
        .btn-confirm:hover { background: #fff; box-shadow: 0 0 30px #fff; transform: scale(1.05); }

        .btn-delete { color: #ff4b2b; cursor: pointer; transition: 0.3s; font-size: 1.2rem; }
        .btn-delete:hover { color: #fff; transform: scale(1.2); }

        .empty-msg { text-align: center; padding: 100px; }
    </style>
</head>
<body>

<header>
    <div style="display:flex; align-items:center; gap:15px;">
        <img src="Logo_marque.png" alt="Logo" style="height:40px;">
        <h2 style="font-family: 'Audiowide'; margin:0;">DSS <span style="color:#00d4ff;">PANIER</span></h2>
    </div>
    <div style="font-family: 'Audiowide'; color: #00d4ff;">ÉTAPE 03 / 04</div>
</header>

<div class="container">
    <h1>Récapitulatif de votre sélection</h1>

    <?php if (empty($_SESSION['panier'])): ?>
        <div class="empty-msg">
            <i class="fas fa-shopping-cart" style="font-size: 5rem; color: rgba(255,255,255,0.1); margin-bottom: 20px;"></i>
            <p style="font-size: 1.2rem;">Votre panier est actuellement vide.</p>
            <br><br>
            <a href="choix_produit.php" class="btn-confirm">RETOURNER AU SHOP</a>
        </div>
    <?php else: ?>
        <table class="panier-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Produit</th>
                    <th>Prix Unitaire</th>
                    <th>Quantité</th>
                    <th>PRIX TOTAL</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($_SESSION['panier'] as $id_p => $quantite): 
                    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit = ?");
                    $stmt->execute([$id_p]);
                    $p = $stmt->fetch();
                    
                    if ($p) {
                        $sous_total = $p['prix'] * $quantite;
                        $total_general += $sous_total;
                ?>
                <tr>
                    <td><img src="<?php echo $p['photo']; ?>" class="img-panier"></td>
                    <td style="font-weight:bold;"><?php echo $p['nom_produit']; ?></td>
                    <td><?php echo number_format($p['prix'], 0, '.', ' '); ?> DJF</td>
                    <td><?php echo $quantite; ?></td>
                    <td style="color:#00d4ff; font-weight:900;"><?php echo number_format($sous_total, 0, '.', ' '); ?> DJF</td>
                    <td>
                        <a href="panier.php?action=supprimer&id=<?php echo $id_p; ?>" class="btn-delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php } endforeach; ?>
            </tbody>
        </table>

        <!-- Nouvelle section Checkout corrigée -->
        <div class="checkout-section">
            <div class="total-container">
                <span style="font-family:'Audiowide'; font-size: 1rem;">TOTAL À PAYER :</span><br>
                <span class="total-price"><?php echo number_format($total_general, 0, '.', ' '); ?> DJF</span>
            </div>

            <div class="actions">
                <a href="choix_produit.php" class="btn-continue">
                    <i class="fas fa-arrow-left"></i> CONTINUER LES ACHATS
                </a>
                <a href="confirmation.php" class="btn-confirm">
                    CONFIRMER LA COMMANDE <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>