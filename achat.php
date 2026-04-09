<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DSS | Inscription Elite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&family=Montserrat:wght@300;600;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), 
                        url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
        }

        header {
            padding: 30px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.4);
            border-bottom: 2px solid #00d4ff;
            z-index: 10;
        }

        .logo-box { display: flex; align-items: center; gap: 15px; }
        .logo-box img { height: 60px; border: 2px solid #00d4ff; border-radius: 5px; }
        
        .site-name {
            font-family: 'Audiowide', cursive;
            font-size: 1.5rem;
            color: #00d4ff;
            text-shadow: 0 0 15px rgba(0, 212, 255, 0.6);
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column; /* Changé pour empiler le bouton et la carte */
            justify-content: center;
            align-items: center;
            padding: 40px 0;
        }

        /* --- BOUTON RETOUR STYLE --- */
        .back-link {
            align-self: flex-start;
            margin-left: calc(50% - 250px); /* Aligné sur le bord gauche de la carte */
            margin-bottom: 20px;
            text-decoration: none;
            color: #fff;
            font-family: 'Audiowide';
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            opacity: 0.7;
        }

        .back-link i {
            padding: 10px;
            border: 1px solid #00d4ff;
            border-radius: 50%;
            font-size: 0.8rem;
        }

        .back-link:hover {
            opacity: 1;
            color: #00d4ff;
            transform: translateX(-5px);
        }

        .glass-card {
            background: rgba(15, 15, 15, 0.9);
            backdrop-filter: blur(20px);
            border: 2px solid #00d4ff;
            border-radius: 30px;
            padding: 50px;
            width: 500px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9), 0 0 20px rgba(0, 212, 255, 0.2);
            animation: slideIn 1s ease-out;
        }

        @keyframes slideIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        h2 {
            font-family: 'Audiowide', cursive;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 45px;
            color: #fff;
            letter-spacing: 3px;
        }

        .input-group {
            position: relative;
            margin-bottom: 40px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .input-group input {
            width: 100%;
            padding: 12px 0;
            font-size: 1.1rem;
            color: #fff;
            background: transparent;
            border: none;
            outline: none;
        }

        .input-group label {
            position: absolute;
            top: 12px;
            left: 0;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.4);
            transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            pointer-events: none;
            text-transform: uppercase;
            font-weight: 600;
        }

        .input-group input:focus ~ label,
        .input-group input:valid ~ label {
            top: -25px;
            font-size: 0.8rem;
            color: #00d4ff;
            letter-spacing: 2px;
        }

        .input-group::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #00d4ff;
            transition: 0.5s;
        }

        .input-group:focus-within::after { width: 100%; }

        .btn-action {
            width: 100%;
            padding: 18px;
            border: 2px solid #00d4ff;
            background: transparent;
            color: #00d4ff;
            font-family: 'Audiowide', cursive;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.4s;
            border-radius: 50px;
            margin-top: 20px;
            text-transform: uppercase;
        }

        .btn-action:hover {
            background: #00d4ff;
            color: #000;
            box-shadow: 0 0 30px #00d4ff;
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<header>
    <div class="logo-box">
        <img src="Logo_marque.png" alt="DSS">
        <span class="site-name">DJIBOUTI SPORT SHOP</span>
    </div>
    <div style="font-family: 'Audiowide'; color: #00d4ff; font-size: 0.9rem;">
        STEP <span style="color: #fff;">01</span> / 04
    </div>
</header>

<div class="container">
    <!-- Le bouton Retour vers ACUEILL.html -->
    <a href="ACUEILL.html" class="back-link">
        <i class="fas fa-arrow-left"></i> RETOUR À L'ACCUEIL
    </a>

    <div class="glass-card">
        <h2>IDENTIFICATION</h2>
        
        <form action="traitement_client.php" method="POST">
            <div class="input-group">
                <input type="text" name="nom" required autocomplete="off">
                <label>Nom de famille</label>
            </div>
            <div class="input-group">
                <input type="text" name="prenom" required autocomplete="off">
                <label>Prénom</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" required autocomplete="off">
                <label>Adresse Email</label>
            </div>
            <div class="input-group">
                <input type="tel" name="telephone" required autocomplete="off">
                <label>Téléphone</label>
            </div>
            <div class="input-group">
                <input type="password" name="mot_de_passe" required autocomplete="off">
                <label>Mot de passe</label>
            </div>

            <button type="submit" class="btn-action">Lancer l'expérience</button>
        </form>
    </div>
</div>

</body>
</html>