<?php
require_once('includes/config.php');
require_once('includes/classes/Entity.class.php');
require_once('includes/classes/Video.class.php');

$metaTitle = "Catégorie ". $_GET['slug'];
$metaDescription = "Toutes les séries & interventions sur ".$_GET['slug']. " réalisées par Metmati Maamar";
$metaIndex = "index";
$metaFollow = "follow";
$metaImageSrc = "metmati-maamar.jpg";
$canonical = 'categorie-'.$_GET['id'].'-'.$_GET['slug'];
$CssStyle = "assets/style/style.css";
$script2 = "";
$script = "";
$content = ob_get_clean();
require_once("includes/header.php");

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    ErrorMessage::show("Aucune Catégorie trouvée");
}

$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers = new CategoryContainers($connection, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);
require_once("includes/footer.php");
?>
