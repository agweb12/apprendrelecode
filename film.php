<?php
require_once('includes/config.php');
require_once('includes/classes/Entity.class.php');
require_once('includes/classes/Video.class.php');

$metaTitle = "Invervention";
$metaDescription = "Toutes les interventions islamiques réalisées par Metmati Maamar : Etudes de livres, réfutations des imams de France, Analyses des hadiths";
$metaIndex = "index";
$metaFollow = "follow";
$metaImageSrc = "metmati-maamar.jpg";
$canonical = "intervention";
$CssStyle = "assets/style/style.css";
$script2 = "";
$script = "";
$content = ob_get_clean();
require_once("includes/header.php");

$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createFilmPreviewVideo();

$containers = new CategoryContainers($connection, $userLoggedIn);
echo $containers->showFilmsCategories();
require_once("includes/footer.php");
?>