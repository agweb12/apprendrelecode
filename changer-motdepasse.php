<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.class.php");
require_once("includes/classes/Account.class.php");
require_once("includes/classes/Constants.class.php");
    $account = new Account($connection);

$message = "";
$token = $_GET['token'];
$pw = $_POST['user-ChangePassword'];
$pw2 = $_POST['user-ChangePasswordConfirm'];

if(empty($token)){
    echo "Cette page n'existe pas. Veuillez cliquer sur le lien envoyer par mail pour changer votre mot de passe";
    exit;
}

//on récuperer les infos du token de la bd
$query = $connection->prepare('SELECT date_token FROM users WHERE motdepasse_token =:token');
$query->bindValue(":token", $token);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);

if (empty($row)) {
    echo "Ce lien n'existe pas";
    exit;
}

$date_token = $row['date_token'];
//on calcule la date de la génération du token + 1heure
$dateToken = strtotime('+1 hours', strtotime($date_token));
$dateToday = time();

if($dateToken < $dateToday){
    echo "Le Token est expiré. Veuillez renouveller votre demande de changement de mot de passe";
    exit;
}
// Si le formulaire a été soumis
if(isset($_POST['btn_user_ChangePassword'])){
    // si le form est correctement rempli
    if(isset($pw) && isset($pw2)){
        //si les deux mots de passes sont les mêmes
        if($pw === $pw2){
        //si les mots de passes sont inférieurs à 12 caractères et supérieur à 300
            if(strlen($pw) >= 12 && strlen($pw) <= 300){
                //on hash le mdp
                $password = hash("sha512",$pw);
                $requete = "UPDATE users SET motdepasse=:pw, motdepasse_token=''
                WHERE motdepasse_token=:token";
                //on modifie les infos
                $query = $connection->prepare($requete);
                $query->bindValue(":pw", $password, PDO::PARAM_STR);
                $query->bindValue(":token", $token, PDO::PARAM_STR);
                $query->execute();

                header('Location: connexion');
            } else{
                $message = '<div style="color:red;">Le mot de passe doit contenir entre 12 et 300 caractères<div>';
            }
        } else {
            $message = '<div style="color:red;">Les deux mots de passe ne sont pas identiques<div>';
        }
    }else {
        $message = '<div style="color:rgb(0, 210, 105);">Veuillez remplir tous les champs du formulaire<div>';
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
    <title>Changer mon mot de passe</title>
    <meta name="description" content="Je change mon mot de passe quand je le souhaite">
    <meta name="twitter:image" content="https://metmatimaamar.com/metmati-maamar.jpg">
    <meta name="twitter:description" content="Je change mon mot de passe quand je le souhaite">
    <meta name="facebook-domain-verification" content="st8u236704bffrw1xreqtkwvy98hm7" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MaamarMetmati">
    <meta name="twitter:creator" content="@MaamarMetmati">
    <meta name="twitter:title" content="Changer mon mot de passe">

    <meta property="og:title" content="Changer mon mot de passe" />
    <meta property="og:description" content="Je change mon mot de passe quand je le souhaite"/>
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
            <h1>Nouveau Mot de Passe</h1>
            <form class="form-changing" action="" method="post">
                <input type="password" id="inputChangePassword" name="user-ChangePassword" class="form-control" placeholder="Saisir un nouveau mot de passe" required="" autofocus="">
                <input type="password" id="inputChangePasswordConfirm" name="user-ChangePasswordConfirm" class="form-control" placeholder="Confirmer le nouveau mot de passe" required="" autofocus="">
                <div class="d-grid gap-2">
                    <button  style="margin: 3px 0 10px 0" class="btn btn-primary " name="btn_user_ChangePassword" type="submit">Changer le mot de passe</button>
                </div>
            </form>
            <?php echo $message ?>
            <a href="connexion" class="changemdp" style="margin: 20px 0 10px 0">Annuler la modification du mot de passe</a>
            <a href="inscription" class="connectionMessage">Besoin de t'inscrire ? Inscrits-toi ici !</a>
        </div>
    </div>
</body>
</html>