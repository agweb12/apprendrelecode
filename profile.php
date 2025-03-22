<?php
require_once('includes/config.php');
require_once("includes/classes/User.class.php");
require_once('includes/classes/Video.class.php');

$metaTitle = "Mon Compte";
$metaDescription = "Votre compte pour conserver ou mettre à jour vos coordonnées";
$metaIndex = "noindex";
$metaFollow = "nofollow";
$metaImageSrc = "maamar-metmati.jpeg";
$canonical = "profil";
$CssStyle = "assets/style/style.css";
$script2 = "";
$script = "";
$content = ob_get_clean();
require_once("includes/header.php");

$detailsMessage = "";
$passwordMessage = "";

if (isset($_POST["saveDetailsButton"])) {
    $account = new Account($connection);

    $prenom = FormSanitizer::sanitizeFormString($_POST["prenom"]);
    $nom = FormSanitizer::sanitizeFormString($_POST["nom"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if($account->updateDetails($prenom,$nom,$email,$userLoggedIn)){
        $detailsMessage = "<div class='alertSuccess'>
                            Vous avez mis à jour vos informations !
                            </div>";
    }
    else{
        $erreurMessage = $account->getPremiereErreur();

        $detailsMessage = "<div class='alertError'>
                            $erreurMessage
                            </div>";
    }

}


if (isset($_POST["savePasswordButton"])) {
    $account = new Account($connection);

    $ancienMotdepasse = FormSanitizer::sanitizeFormPassword($_POST["ancienMotdepasse"]);
    $nouveauMotdepasse = FormSanitizer::sanitizeFormPassword($_POST["nouveauMotdepasse"]);
    $nouveauMotdepasse2 = FormSanitizer::sanitizeFormPassword($_POST["nouveauMotdepasse2"]);

    if($account->updatePassword($ancienMotdepasse, $nouveauMotdepasse, $nouveauMotdepasse2, $userLoggedIn)){
        $passwordMessage = "<div class='alertSuccess'>
                            Vous avez mis à jour votre mot de passe !
                            </div>";
    }
    else{
        $erreurMessage = $account->getPremiereErreur();

        $passwordMessage = "<div class='alertError'>
                            $erreurMessage
                            </div>";
    }
}

?>

<div class="settingsContainer columnProfile">
    <div class="formSection">
        <form method="POST">
            <h2>Détails Utilisateur</h2>

            <?php
            $user = new User($connection, $userLoggedIn);

            $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : $user->getPrenom();
            $nom = isset($_POST["nom"]) ? $_POST["nom"] : $user->getNom();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
            ?>

            <input type="text" name="prenom" placeholder="Prénom" value="<?php echo $prenom; ?>">
            <input type="text" name="nom" placeholder="Nom de Famille" value="<?php echo $nom; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
            <div class="message">
                <?php echo $detailsMessage; ?>
            </div>
            <input type="submit" name="saveDetailsButton" value="Sauvegarder">
        </form>
    </div>
    <div class="formSection">
        <form action="" method="POST">
            <h2>Mettre à jour votre mot de passe</h2>
            <input type="password" name="ancienMotdepasse" placeholder="Mot de passe actuel">
            <input type="password" name="nouveauMotdepasse" placeholder="Nouveau Mot de passe">
            <input type="password" name="nouveauMotdepasse2" placeholder="Confirmation nouveau mot de passe">
            <div class="message">
                <?php echo $passwordMessage; ?>
            </div>
            <input type="submit" name="savePasswordButton" value="Sauvegarder">
        </form>
    </div>
    <div>
        <?php
            
            ?>
    </div>

</div>