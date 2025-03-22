<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.class.php");
require_once("includes/classes/Account.class.php");
require_once("includes/classes/Constants.class.php");
    $account = new Account($connection);

$message = "";

if(isset($_POST['btn_user_reset'])){
    if(!empty($_POST['user-resetEmail'])){
        $query = $connection->prepare('SELECT COUNT(*) AS nb FROM users WHERE email = ?');
        $query->bindValue(1, $_POST['user-resetEmail']);
        $query->execute();

        $ligne = $query->fetch(PDO::FETCH_ASSOC);
        // on teste si le mail est associé à un compte
        if(!empty($ligne) && $ligne['nb'] > 0){
            //on genere un token
            $string = implode('', array_merge(range('A','Z'), range('a','z'), range('0','9')));
            $token = substr(str_shuffle($string), 0, 20);

            //on insere la date et le token dans le DB
            $query = $connection->prepare('UPDATE users SET date_token = NOW(), motdepasse_token = ? WHERE email = ?');
            $query->bindValue(1, $token);
            $query->bindValue(2, $_POST['user-resetEmail']);
            $query->execute();

            //on prepare l'envoi de l'email
            $link = 'https://metmatimaamar.com/changer-motdepasse.php?token='.$token;
            $to = $_POST['user-resetEmail'];
            $subject = 'Réinitialisation de votre mot de passe';
            $message = '<h1>Réinitialisation de votre mot de passe</h1><br><br><p>Pour réinitialiser votre mot de passe, veuillez suivre ce lien: <a href="'.$link.'">'.$link.'</a></p>';

            $header = [];
            $headers[] = 'From: Maamar Metmati <info@metmatimaamar.com>';
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            //on envoie le courriel
            mail($to,$subject,$message,implode("\r\n", $headers));
            $message = '<div style="color:rgb(0, 210, 105);">Un mail vient d\'être envoyé : <b>N\'oubliez pas de vérifier dans votre section SPAM ou PROMOTIONS</b><div>';
        } else{
            $message = "<div style='color:red'>Cet email n'existe pas. Veuillez saisir un mail valide</div>";
        }
    }else{
        $message = "<div style='color:red'>Veuillez spécifier une adresse mail</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FEQ55N7FPL"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FEQ55N7FPL');
        </script>
    <!-- END GOOGLE TAG -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Authentification</title>
    <meta name="description" content="Authentifier son mail">
    <meta name="twitter:image" content="https://metmatimaamar.com/metmati-maamar.jpg">
    <meta name="twitter:description" content="Authentifier son mail">
    <meta name="facebook-domain-verification" content="st8u236704bffrw1xreqtkwvy98hm7" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MaamarMetmati">
    <meta name="twitter:creator" content="@MaamarMetmati">
    <meta name="twitter:title" content="Authentification">

    <meta property="og:title" content="Authentification" />
    <meta property="og:description" content="Authentifier son mail"/>
    <meta property="og:image" content="https://metmatimaamar.com/metmati-maamar.jpg" />
    <meta property="og:site_name" content="Metmati Maamar"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.metmatimaamar.com/" />

    <meta name="fragment" content="!">
    <link rel="image_src" href="https://metmatimaamar.com/metmati-maamar.jpg">
    <link rel="canonical" href="https://www.metmatimaamar.com/">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="loginContainer">
        <div class="columnLogin">
            <img src="assets/images/logo.png" alt="Site logo" title="logo">
            <h1>Changer de mot de passe</h1>
            <p>Nous vous envoyons un mail sur votre adresse mail</p>
            <p class="acces"><u>N'oubliez pas de vérifier dans vos SPAMS ou PROMOTIONS</u></p>
            <form action="authentification" method="post">
                <input type="email" id="resetEmail" name="user-resetEmail" class="form-control" placeholder="Entrez votre email" required="" autofocus="">
                <div class="d-grid gap-2">
                    <button  style="margin: 3px 0 10px 0" class="btn btn-primary " name="btn_user_reset" type="submit">Réinitialiser le mot de passe</button>
                </div>
                <?php echo $message ?>
            </form>
            <a href="connexion" class="changemdp" style="margin: 20px 0 10px 0">Annuler la modification du mot de passe</a>
            <a href="inscription" class="connectionMessage">Besoin de t'inscrire ? Inscrits-toi ici !</a>
        </div>
    </div>
</body>
</html>