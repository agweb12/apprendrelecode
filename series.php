<?php
require_once('includes/config.php');
require_once('includes/classes/Entity.class.php');
require_once('includes/classes/Video.class.php');

$metaTitle = "Séries";
$metaDescription = "Toutes les séries islamiques réalisées par Metmati Maamar : Etudes de livres, réfutations des imams de France, Analyses des hadiths";
$metaIndex = "index";
$metaFollow = "follow";
$metaImageSrc = "metmati-maamar.jpg";
$CssStyle = "assets/style/style.css";
$canonical = 'series';
$script2 = "";
$script = "";
$content = ob_get_clean();
require_once("includes/header.php");

$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createSeriesPreviewVideo();

$containers = new CategoryContainers($connection, $userLoggedIn);
echo $containers->showSeriesCategories();
include_once("includes/footer.php");
?>