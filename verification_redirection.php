<?php
session_start();

// 1. Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "projet_web");

// 2. Récupération des données du formulaire
$user_saisi = $_POST['username'];
$mdp_saisi  = $_POST['password'];

// 3. Requête SQL pour chercher le NOM
$sql = "SELECT * FROM gestion_administrateur WHERE Nom = '$user_saisi' AND mdp = '$mdp_saisi'";
$resultat = mysqli_query($connexion, $sql);

// 4. Vérification
if (mysqli_num_rows($resultat) == 1) {
    // CONNEXION RÉUSSIE
    $_SESSION['nom'] = $user_saisi;
    header("Location: interface_administrateur.php");
    exit();
} else {
    // CONNEXION ÉCHOUÉE : On affiche la page d'erreur
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Erreur de connexion</title>
    <link rel="stylesheet" type="text/css" href="style_erreur.css">
</head>
<body>

    <div class="box-erreur">
        <img src="Logo_marque.png" width="80">
        <h1>Accès Refusé</h1>
        <p>Désolé, le nom d'utilisateur <b><?php echo $user_saisi; ?></b> ou le mot de passe <b><?php echo $mdp_saisi; ?></b> est incorrect !</p>
        
        <div class="liens">
            <a href="Page_autorisation.php" class="btn-retour">Réessayer</a>
        </div>
    </div>

</body>
</html>
<?php
}
mysqli_close($connexion);
?>