<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.class.php");
require_once("includes/classes/Account.class.php");
require_once("includes/classes/Constants.class.php");
    $account = new Account($connection);
    $message = '<div style="color:rgb(0, 210, 105);">Votre mot de passe a bien été changé !<div>';


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
    <title>Vérification MDP</title>
    <meta name="description" content="Vérification MDP">
    <meta name="twitter:image" content="https://metmatimaamar.com/metmati-maamar.jpg">
    <meta name="twitter:description" content="Vérification MDP">
    <meta name="facebook-domain-verification" content="st8u236704bffrw1xreqtkwvy98hm7" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MaamarMetmati">
    <meta name="twitter:creator" content="@MaamarMetmati">
    <meta name="twitter:title" content="Vérification MDP">

    <meta property="og:title" content="Vérification MDP" />
    <meta property="og:description" content="Vérification MDP"/>
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
            <?php echo $message ?>
            <a href="connexion" class="connectionMessage">Se Connecter</a>
        </div>
    </div>
</body>
</html>