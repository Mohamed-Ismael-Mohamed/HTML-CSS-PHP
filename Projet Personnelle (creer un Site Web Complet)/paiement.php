<?php
session_start();

if (!isset($_SESSION['temp_id_facture'])) {
    header("Location: choix_produit.php");
    exit();
}

$total = $_SESSION['temp_total'];
$id_fac = $_SESSION['temp_id_facture'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement Sécurisé | DSS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&family=Montserrat:wght@300;400;700;900&display=swap');
        
        body { background: #0a0a0a; color: #fff; font-family: 'Montserrat', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        
        .payment-container {
            background: #111;
            border: 2px solid #00d4ff;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 50px rgba(0, 212, 255, 0.1);
        }

        h1 { font-family: 'Audiowide'; color: #00d4ff; text-align: center; font-size: 1.8rem; margin-bottom: 10px; }
        .amount-badge { background: rgba(0, 212, 255, 0.1); color: #00d4ff; padding: 15px; border-radius: 10px; text-align: center; font-size: 1.5rem; font-weight: 900; margin-bottom: 30px; border: 1px dashed #00d4ff; }

        .method-card {
            background: #1a1a1a;
            border: 1px solid #333;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .method-card:hover { border-color: #00d4ff; background: #222; }
        
        .method-card input[type="radio"] { margin-right: 15px; accent-color: #00d4ff; transform: scale(1.3); }

        .method-info { flex-grow: 1; }
        .method-info i { font-size: 1.5rem; margin-right: 15px; width: 30px; text-align: center; color: #00d4ff; }
        .method-info span { font-weight: bold; font-size: 1rem; }

        .input-group { margin-top: 20px; display: none; } 
        
        input[type="text"] {
            width: 100%; padding: 12px; background: #000; border: 1px solid #333; color: #fff; border-radius: 5px; box-sizing: border-box; margin-top: 10px;
        }

        .btn-confirm {
            width: 100%;
            background: #00d4ff;
            color: #000;
            padding: 18px;
            border: none;
            border-radius: 50px;
            font-family: 'Audiowide';
            font-size: 1rem;
            cursor: pointer;
            margin-top: 25px;
            transition: 0.3s;
        }

        .btn-confirm:hover { background: #fff; box-shadow: 0 0 20px #fff; transform: scale(1.02); }

        .back-link { display: block; text-align: center; margin-top: 20px; color: #666; text-decoration: none; font-size: 0.8rem; }
        .back-link:hover { color: #fff; }
    </style>
</head>
<body>

<div class="payment-container">
    <h1><i class="fas fa-shield-alt"></i> CHECKOUT</h1>
    <p style="text-align: center; color: #888;">Facture #<?php echo $id_fac; ?></p>
    
    <div class="amount-badge">
        <?php echo number_format($total, 0, '.', ' '); ?> DJF
    </div>

    <form action="confirmation_finale.php" method="POST">
        <label class="method-card">
            <input type="radio" name="methode" value="D-Money / Waafi" checked>
            <div class="method-info">
                <i class="fas fa-mobile-alt"></i>
                <span>D-Money / Waafi</span>
            </div>
        </label>

        <label class="method-card">
            <input type="radio" name="methode" value="Carte Bancaire">
            <div class="method-info">
                <i class="fas fa-credit-card"></i>
                <span>Carte Visa / Mastercard</span>
            </div>
        </label>

        <label class="method-card">
            <input type="radio" name="methode" value="Espèces">
            <div class="method-info">
                <i class="fas fa-money-bill-wave"></i>
                <span>Paiement à la livraison</span>
            </div>
        </label>

        <div id="extra-info">
            <p style="font-size: 0.8rem; color: #888; margin-bottom: 5px;">Numéro de téléphone ou de carte :</p>
            <input type="text" name="details_paiement" placeholder="Ex: 77 81 XX XX" required>
        </div>

        <button type="submit" class="btn-confirm">
            PAYER MAINTENANT <i class="fas fa-lock"></i>
        </button>

        <a href="confirmation.php" class="back-link">RETOUR À LA FACTURE</a>
    </form>
</div>

</body>
</html>