<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.class.php");
require_once("includes/classes/Account.class.php");
require_once("includes/classes/Constants.class.php");
require_once("includes/classes/Video.class.php");
require_once('includes/classes/Entity.class.php');
require_once('includes/classes/SeasonProvider.class.php');
require_once('includes/classes/Season.class.php');
require_once('includes/classes/VideoProvider.class.php');
require_once('includes/classes/PreviewProvider.class.php');
require_once('includes/classes/CategoryContainers.class.php');
require_once('includes/classes/EntityProvider.class.php');

$account = new Account($connection);

if (isset($_POST['inscriptionBouton'])) {
    $prenom = FormSanitizer::sanitizeFormString($_POST["prenom"]);
    $nom = FormSanitizer::sanitizeFormString($_POST["nom"]);
    $pseudonyme = FormSanitizer::sanitizeFormPseudo($_POST["pseudo"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["motdepasse"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["motdepasse2"]);

    $success =  $account->inscription($prenom, $nom, $pseudonyme, $email, $email2, $password, $password2);


    if ($success) {
        $_SESSION['userLoggedIn'] = $pseudonyme;
        header("Location: accueil");
    }
}

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Google tag (gtag.js)
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FEQ55N7FPL"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FEQ55N7FPL');
        </script>
END GOOGLE TAG -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <title>S'inscrire</title>
    <meta name="description" content="S'inscrire pour se former sur apprendrelecode.com">
    <meta name="twitter:image" content="https://apprendrelecode.com/">
    <meta name="twitter:description" content="S'inscrire pour se former sur apprendrelecode.com">
    <meta name="facebook-domain-verification" content="st8u236704bffrw1xreqtkwvy98hm7" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="S'inscrire">

    <meta property="og:title" content="S'inscrire" />
    <meta property="og:description" content="S'inscrire pour se former sur apprendrelecode.com" />
    <meta property="og:image" content="https://apprendrelecode.com/" />
    <meta property="og:site_name" content="Alexandre Graziani" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.apprendrelecode.com/inscription" />

    <meta name="fragment" content="!">
    <link rel="image_src" href="https://apprendrelecode.com/">
    <link rel="canonical" href="https://www.apprendrelecode.com/inscription">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/b83fa86058.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="inscriptionContainer">
        <div class="registerBar">
            <img src="assets/images/logo.png" alt="Site logo" title="logo">
            <a href="connexion" class="connectBar">S'identifier</a>
        </div>
        <div class="column">
            <div class="column2">
                <h1>Formations en <span>Programmation</span></h1>
                <h2><span>Vidéos</span><br>en illimité</h2>
                <p>Où que vous soyez, visionner différentes formations</p>
                <h3>S'inscrire sur apprendrelecode.com pour accéder à toutes mes <u>formations</u></h3>
                <form action="" method="POST">
                    <input type="text" name="prenom" placeholder="Prénom" value="<?php getInputValue("prenom") ?>" required>
                    <?php echo $account->getError(Constants::$prenomCaracteres); ?>

                    <input type="text" name="nom" placeholder="Nom de Famille" value="<?php getInputValue("nom") ?>" required>
                    <?php echo $account->getError(Constants::$nomCaracteres); ?>

                    <input type="text" name="pseudo" placeholder="Pseudonyme" value="<?php getInputValue("pseudo") ?>" required>
                    <?php echo $account->getError(Constants::$pseudoCaracteres); ?>
                    <?php echo $account->getError(Constants::$pseudoPris); ?>

                    <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email") ?>" required>
                    <?php echo $account->getError(Constants::$emailsDontMatch); ?>
                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                    <?php echo $account->getError(Constants::$emailPris); ?>

                    <input type="email" name="email2" placeholder="Confirmez votre email" value="<?php getInputValue("email2") ?>" required>

                    <input type="password" name="motdepasse" placeholder="Mot de Passe" required>
                    <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
                    <?php echo $account->getError(Constants::$passwordCaracteres); ?>

                    <input type="password" name="motdepasse2" placeholder="Confirmez votre mot de passe" required>

                    <input type="submit" name="inscriptionBouton" value="S'INSCRIRE">
                </form>

                <a href="connexion" class="inscriptionMessage">Vous avez déjà un compte ? Connectez-vous ici !</a>
            </div>
        </div>
        <hr class="rounded">
        <div class="section1">
            <div class="section2">
                <h2>Regardez nos vidéos en illimité, <br>sur tout support</h2>
                <h3>Regardez mes formations, et apprenez tout en codant en accès illimité, et actualisé mensuellement</h3>
            </div>
            <img src="" alt="Présentation du site Responsive apprendrelecode.com">
        </div>
        <hr class="rounded">
        <div class="section1">
            <img src="" alt="Présentation du site Responsive apprendrelecode.com">
            <div class="section2">
                <h2>Où que vous soyez</h2>
                <h3>Uniquement des vidéos pour apprendre à coder.</h3>
            </div>
        </div>
        <hr class="rounded">
        <div class="section1">
            <div class="section2">
                <h2>En vous inscrivant</h2>
                <h3>Retrouvez mes formations <u>en lecture</u> ou <u>déjà visionnées</u>,<br>au moment où vous vous êtes arrêtés</h3>
            </div>
            <div class="section10">
                <video src="" type="video/mp4" autoplay loop muted></video>
            </div>
        </div>
        <hr class="rounded">
        <div class="section1">
            <div class="section2">
                <h2>Suivez Moi sur les réseaux sociaux</h2>
                <div itemscope itemtype="https://schema.org/Organization" class="reseauxsociaux">
                    <a itemprop="sameAs" href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a itemprop="sameAs" href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube fa-beat-fade"></i></a>
                    <a itemprop="sameAs" href="https://www.instagram.com//?hl=fr" target="_blank"><i class="fa-brands fa-instagram fa-bounce"></i></a>
                    <a itemprop="sameAs" href="https://twitter.com/" target="_blank"><i class="fa-brands fa-twitter fa-spin fa-spin-reverse"></i></a>
                    <a itemprop="sameAs" href="https://t.me/" target="_blank"><i class="fa-brands fa-telegram fa-bounce"></i></a>
                    <a itemprop="sameAs" href="https://www.tiktok.com/@" target="_blank"><i class="fa-brands fa-tiktok fa-bounce"></i></a>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="section5">
            <div itemscope itemtype="https://schema.org/Organization" id="contact" class="col">
                <span itemprop="url" content="https://apprendrelecode.com"><a href=""><img class="logo" itemprop="logo" src="assets/images/" class="logo" alt=""></a></span>
                <p><strong><span itemprop="name">Alexandre Graziani</span></strong> | <span itemprop="alternateName">Alexandre Graziani Web</span></p>

                <h4>Contactez-Nous</h4>
                <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                    <p><strong><span itemprop="addresseLocality"></span>Adresse : </strong>Paris</p>
                </div>
                <p><strong>Téléphone : </strong><span itemprop="telephone">(+33) 7 79 13 44 95</span></p>
                <p><strong>Mail : </strong><span itemprop="email">contact@apprendrelecode.com</span></p>
                <p><strong>Horaires : </strong>9h00 - 18h00 du Lundi au Vendredi</p>
            </div>
            <div class="follow">
                <h4>Suivez-nous, c'est par ici !</h4>
                <div itemscope itemtype="https://schema.org/Organization" class="icon">
                    <a itemprop="sameAs" href="https://www.facebook.com/MaamarMetmatiOfficiel" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a itemprop="sameAs" href="https://www.youtube.com/c/MaamarMetmatiOfficiel12" target="_blank"><i class="fa-brands fa-youtube fa-beat-fade"></i></a>
                    <a itemprop="sameAs" href="https://www.instagram.com/maamarmetmati/?hl=fr" target="_blank"><i class="fa-brands fa-instagram fa-bounce"></i></a>
                    <a itemprop="sameAs" href="https://twitter.com/OfficielMaamar" target="_blank"><i class="fa-brands fa-twitter fa-spin fa-spin-reverse"></i></a>
                    <a itemprop="sameAs" href="https://t.me/maamarmetmati" target="_blank"><i class="fa-brands fa-telegram fa-bounce"></i></a>
                    <a itemprop="sameAs" href="https://www.tiktok.com/@maamarmetmati" target="_blank"><i class="fa-brands fa-tiktok fa-bounce"></i></a>
                </div>
            </div>
            <div class="col">
                <h4>À mon propos</h4>
                <a href="https://">À propos de l'éditeur : Maamar Metmati</a>
            </div>
            <div class="col">
                <a href="https://maamarmetmati.fr/livres">Tout savoir sur mes compétences</a>
                <h4>Mes Formations en Livre</h4>
                <a href="https://maamarmetmati.fr/articles" target="_blank">Pour lire mes livres</a>
                <a href="https://www.youtube.com/c/" target="_blank">Sur Youtube</a>
                <a href="https://www.facebook.com/" target="_blank">Sur Facebook</a>
                <a href="https://t.me/" target="_blank">Sur Telegram</a>
            </div>
            <div class="siteInternet">
                <a class="p21" href="https://github.com/agweb12">AG WEB 12</a>
                <a class="p21" href="https://agwebcreation.fr">agwebcreation.fr</a>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright @2025 <i id="common" class="fab fa-creative-commons"></i> - apprendrelecode.com - Créé par عبد الرحمن</p>
            <i class="fab fa-fab fa-html5"></i>
            <i class="fab fa-fab fa-css3-alt"></i>
            <i class="fab fa-fab fa-js"></i>
            <i class="fab fa-fab fa-php"></i>
        </div>
    </footer>
</body>

</html>