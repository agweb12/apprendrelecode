<?php
require_once('includes/config.php');
require_once('includes/classes/Entity.class.php');
require_once('includes/classes/Video.class.php');
$entityId = $_GET["id"];
$entity = new Entity($connection, $entityId);

$metaTitle = $entity->getName();
$metaDescription = $entity->getDescriptifSerieFilm();
$metaIndex = "index";
$metaFollow = "follow";
$metaImageSrc = $entity->getThumbnail();
$canonical = 'entite-'.$entityId.'-'.$entity->getSlugEntity();
$CssStyle = "assets/style/style.css";
$script2 = "";
$script = "";
$content = ob_get_clean();
require_once("includes/header.php");

$entitySlug = $entity->getSlugEntity();

if((!isset($_GET["id"]) || empty($_GET["id"])) || (!isset($entitySlug) || empty($entitySlug))){
    ErrorMessage::show("Aucune série ou intervention trouvée");
    header('Location : accueil');
}
$sharing = "";
$entityId = $_GET["id"];
$entity = new Entity($connection, $entityId);

$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$sharing .= '<h1 class="serieSeason">'.$entity->getName().'</h1>';
$sharing .= '<div class="subshare-video-metmati centered">';
$sharing .= '<a href="https://www.facebook.com/sharer.php?u=https://metmatimaamar.com/entite-'.$entity->getId().'-'.$entity->getSlugEntity().'&t='.$entity->getName().'target="_blank"><i class="fab fa-facebook"></i></a>';
$sharing .= '<a href="https://t.me/share/url?url=https://metmatimaamar.com/entite-'.$entity->getId().'-'.$entity->getSlugEntity().'&text='.$entity->getName().'"target="_blank"><i class="fab fa-telegram"></i></a>' ;
$sharing .= '<a href="https://twitter.com/share?url=https://metmatimaamar.com/entite-'.$entity->getId().'-'.$entity->getSlugEntity().'&amp;text='.$entity->getName().'&amp;hashtags=islam" target="_blank"><i class="fab fa-fab fa-twitter"></i></a>';
$sharing .= '</div>';
echo $sharing;

$seasonProvider = new SeasonProvider($connection, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($connection, $userLoggedIn);
echo $categoryContainers->showAimerCategory($entity->getCategoryId(), "Ce que tu pourrais peut-être aimer");

require_once("includes/footer.php");
?>