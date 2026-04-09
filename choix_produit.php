<?php
session_start();
// Vérification : si le client n'est pas passé par l'étape 1, on le renvoie à achat.php
if (!isset($_SESSION['id_client'])) {
    header("Location: achat.php");
    exit();
}

// Connexion BDD
$host = 'localhost'; $dbname = 'projet_web'; $user = 'root'; $pass = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // On récupère tous les produits
    $stmt = $pdo->query("SELECT * FROM produit");
    $produits = $stmt->fetchAll();
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DSS | Catalogue Elite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&family=Montserrat:wght@300;600;900&display=swap');
        
        body {
            background: #0a0a0a;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
        }

        header {
            padding: 15px 5%;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border-bottom: 2px solid #00d4ff;
            background: rgba(0,0,0,0.9);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-container { display: flex; align-items: center; gap: 15px; }
        .logo-img { height: 50px; border: 1px solid #00d4ff; border-radius: 5px; }

        .welcome-msg { font-family: 'Audiowide'; color: #00d4ff; font-size: 0.9rem; }

        .header-actions { display: flex; align-items: center; gap: 15px; }

        .btn-cart {
            text-decoration: none;
            color: #00d4ff;
            border: 1px solid #00d4ff;
            padding: 8px 15px;
            border-radius: 5px;
            font-family: 'Audiowide';
            font-size: 0.7rem;
            transition: 0.3s;
        }
        .btn-cart:hover {
            background: #00d4ff;
            color: #000;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        .btn-exit {
            text-decoration: none;
            color: #ff4b2b;
            border: 1px solid #ff4b2b;
            padding: 8px 15px;
            border-radius: 5px;
            font-family: 'Audiowide';
            font-size: 0.7rem;
            transition: 0.3s;
        }
        .btn-exit:hover {
            background: #ff4b2b;
            color: #fff;
            box-shadow: 0 0 10px rgba(255, 75, 43, 0.5);
        }

        .catalog-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            padding: 50px 5%;
        }

        .product-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(0,212,255,0.2);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
        }

        .product-card:hover {
            border-color: #00d4ff;
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,212,255,0.2);
        }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: contain;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .price {
            font-size: 1.5rem;
            color: #00d4ff;
            font-weight: 900;
            margin: 10px 0;
        }

        .btn-add {
            background: #00d4ff;
            color: #000;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-family: 'Audiowide';
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            text-transform: uppercase;
        }

        .btn-add:hover { background: #fff; box-shadow: 0 0 15px #fff; }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="Logo_marque.png" alt="DSS" class="logo-img">
        <h2 style="font-family: 'Audiowide'; color:#fff; margin:0;">DSS <span style="color:#00d4ff;">SHOP</span></h2>
    </div>
    
    <div class="welcome-msg">
        <i class="fas fa-user-circle"></i> BIENVENUE, <?php echo strtoupper($_SESSION['client_nom']); ?>
    </div>

    <div class="header-actions">
        <a href="panier.php" class="btn-cart">
            <i class="fas fa-shopping-basket"></i> PANIER 
            (<?php echo isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : '0'; ?>)
        </a>

        <!-- Changement ici : On pointe vers deconnexion.php au lieu de ACUEILL.html -->
        <a href="deconnexion.php" class="btn-exit">
            <i class="fas fa-times"></i> QUITTER
        </a>
    </div>
</header>

<?php if(isset($_GET['success'])): ?>
    <div style="background: #28a745; color: white; text-align: center; padding: 10px; font-family: 'Audiowide'; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> ARTICLE AJOUTÉ AU PANIER !
    </div>
<?php endif; ?>

<div style="text-align:center; margin-top:30px;">
    <p style="color: #00d4ff; font-family: 'Audiowide'; letter-spacing: 2px;">SÉLECTIONNEZ VOS ARTICLES ÉLITES</p>
    <small style="opacity: 0.6;">Étape 02 / 04</small>
</div>

<div class="catalog-container">
    <?php foreach($produits as $p): ?>
    <div class="product-card">
        <img src="<?php echo $p['photo']; ?>" alt="<?php echo $p['nom_produit']; ?>">
        
        <h3><?php echo $p['nom_produit']; ?></h3>
        <p class="price"><?php echo number_format($p['prix'], 2, '.', ' '); ?> DJF</p>
        
        <form action="ajouter_panier.php" method="POST">
            <input type="hidden" name="id_produit" value="<?php echo $p['id_produit']; ?>">
            <button type="submit" class="btn-add">
                <i class="fas fa-shopping-cart"></i> AJOUTER
            </button>
        </form>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>