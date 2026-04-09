<?php
// 1. Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "projet_web");

// 2. Récupération des données du formulaire
$nom = $_POST["nom"];
$genre = $_POST["genre"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];
$date_naissance = $_POST["date_naissance"];
$sport_prefere = $_POST["sport_prefere"];
$mdp = $_POST["password"];

// 3. Insertion dans la table
$sql = "INSERT INTO gestion_administrateur(Nom, genre, email, num_telephone, date_naissance, sport_favorie, mdp) 
        VALUES ('$nom', '$genre', '$email', '$telephone', '$date_naissance', '$sport_prefere', '$mdp')";

$resultat = mysqli_query($connexion, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resultat Inscription</title>
    <style>
        body {
            /* Couleurs du drapeau de Djibouti */
            background: linear-gradient(135deg, #A8E1F8 50%, #51BD21 50%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .carte-message {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 10px 20px rgba(0,0,0,0.2);
            width: 400px;
            border-top: 10px solid #DD171D; /* Le rouge de l'étoile */
        }

        h2 { color: #1e3c72; }
        
        .succes { color: #51BD21; font-weight: bold; }
        .erreur { color: #DD171D; font-weight: bold; }

        .bouton {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1e3c72;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="carte-message">
        <img src="Logo_marque.png" width="80"><br><br>

        <?php if($resultat) { ?>
            <h2 class="succes">Inscription Réussie !</h2>
            <p>Bravo <b><?php echo $nom; ?></b>, vos données ont été bien enregistrées dans la base de donnée <i>projet_web</i>.</p>
            <p>Vous allez maintenant vous diriger sur la Page d'autorisation en inserant vos données afin d'accéder à l'interface ADMINISTRATEUR</p>
        <?php } else { ?>
            <h2 class="erreur">Erreur d'enregistrement</h2>
            <p>Désolé, un problème est survenu lors de l'envoi vers la base de données.</p>
            <p><?php echo mysqli_error($connexion); ?></p>
            <a href="inscription.html" class="bouton">Réessayer</a>
        <?php } ?>

        <br>
        <a href="Page_autorisation.php" class="bouton">Retour à la Page d'autorisation</a>
    </div>

</body>
</html>

<?php mysqli_close($connexion); ?>