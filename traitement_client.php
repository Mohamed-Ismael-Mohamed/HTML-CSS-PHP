<?php
session_start();

$host = 'localhost';
$dbname = 'projet_web';
$user = 'root'; 
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = htmlspecialchars($_POST['email']);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $mot_de_passe = $_POST['mot_de_passe']; 

        // 1. VERIFICATION : Est-ce que cet email existe déjà ?
        $check = $pdo->prepare("SELECT id_client, prenom FROM client WHERE email = :email");
        $check->execute([':email' => $email]);
        $client_existant = $check->fetch();

        if ($client_existant) {
            // LE CLIENT EXISTE DÉJÀ
            // On récupère son ID actuel sans recréer de ligne
            $_SESSION['id_client'] = $client_existant['id_client'];
            $_SESSION['client_nom'] = $client_existant['prenom'];
        } else {
            // LE CLIENT EST NOUVEAU
            // On l'insère dans la base
            $sql = "INSERT INTO client (nom, prenom, email, mot_de_passe, telephone) 
                    VALUES (:nom, :prenom, :email, :mdp, :tel)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom'    => $nom,
                ':prenom' => $prenom,
                ':email'  => $email,
                ':mdp'    => $mot_de_passe,
                ':tel'    => $telephone
            ]);

            // On récupère le nouvel ID
            $_SESSION['id_client'] = $pdo->lastInsertId();
            $_SESSION['client_nom'] = $prenom;
        }

        // Dans les deux cas, on l'envoie vers le catalogue
        header("Location: choix_produit.php");
        exit();
    }

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>