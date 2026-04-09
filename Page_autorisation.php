<?php
session_start();

// 1. GESTION DE LA LANGUE
if (isset($_POST['choix_Langue'])) {
    $_SESSION['lang'] = $_POST['choix_Langue'];
}

$current_lang = $_SESSION['lang'] ?? 'fr';

// 2. LE DICTIONNAIRE (Toutes tes traductions sont ici)
$trad = [
    'fr' => [
        'titre' => 'Bienvenue dans Djibouti Sport Shop',
        'leg_lang' => 'Langue',
        'leg_conn' => 'Connexion',
        'user' => 'Utilisateur :',
        'pass' => 'Mot de passe :',
        'btn' => 'Connexion',
        'new' => 'Nouveau client ?',
        'create' => 'Créer un compte',
        'dir' => 'ltr'
    ],
    'en' => [
        'titre' => 'Welcome to Djibouti Sport Shop',
        'leg_lang' => 'Language',
        'leg_conn' => 'Login',
        'user' => 'Username:',
        'pass' => 'Password:',
        'btn' => 'Login',
        'new' => 'New customer?',
        'create' => 'Create an account',
        'dir' => 'ltr'
    ],
    'ar' => [
        'titre' => 'مرحباً بكم في متجر جيبوتي للرياضة',
        'leg_lang' => 'اللغة',
        'leg_conn' => 'تسجيل الدخول',
        'user' => 'اسم المستخدم:',
        'pass' => 'كلمة المرور:',
        'btn' => 'دخول',
        'new' => 'عميل جديد؟',
        'create' => 'إنشاء حساب',
        'dir' => 'rtl' 
    ],
    'es' => [
        'titre' => 'Bienvenido a Djibouti Sport Shop',
        'leg_lang' => 'Idioma',
        'leg_conn' => 'Conexión',
        'user' => 'Usuario:',
        'pass' => 'Contraseña:',
        'btn' => 'Iniciar sesión',
        'new' => '¿Nuevo cliente?',
        'create' => 'Crear una cuenta',
        'dir' => 'ltr'
    ]
];

// On récupère la liste de mots correspondant à la langue choisie
$l = $trad[$current_lang];
?>

<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" dir="<?php echo $l['dir']; ?>">
<head>
    <meta charset="utf-8">
    <title>Djib-Sport-Shop</title>
    <link rel="icon" type="image/png" href="Logo_marque.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <img src="Logo_marque.png" class="logo">

    <h1><?php echo $l['titre']; ?></h1>

    <form method="post" action="">
        <fieldset>
            <legend><?php echo $l['leg_lang']; ?> <i>(Language)</i></legend>
            <select name="choix_Langue" onchange="this.form.submit()">
                <option value="fr" <?php if($current_lang == 'fr') echo 'selected'; ?>>Français</option>
                <option value="en" <?php if($current_lang == 'en') echo 'selected'; ?>>English</option>
                <option value="ar" <?php if($current_lang == 'ar') echo 'selected'; ?>>العربية</option>
                <option value="es" <?php if($current_lang == 'es') echo 'selected'; ?>>Español</option>
            </select>
        </fieldset>
    </form>

    <form method="post" action="verification_redirection.php">
        <fieldset>
            <legend><?php echo $l['leg_conn']; ?></legend>
            <div class="form-group">
                <label><?php echo $l['user']; ?></label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label><?php echo $l['pass']; ?></label>
                <input type="password" name="password" required>
            </div>
            <button type="submit"><?php echo $l['btn']; ?></button>
            <center> <p class="inscription">
                <?php echo $l['new']; ?> 
                <a href="Inscription.html"><?php echo $l['create']; ?></a>
            </p></center>
        </fieldset>
    </form>
</div>

</body>
</html>