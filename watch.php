<?php
require_once('includes/config.php');
require_once('includes/classes/Video.class.php');
require_once('includes/classes/Entity.class.php');

$video = new Video($connection, $_GET["id"]);
$contentUrl = $video->getFilePath();
$description = str_replace("'", "’", substr($video->getDescription(), 0, 150));
$titre = str_replace("'", "’", $video->getTitle());
$uploadDate = $video->getUploadDate();
$imageFilmSerie = $video->getThumbnail();
$metaTitle = $video->getTitle();
$metaDescription = $video->getDescription();
$metaIndex = "index";
$metaFollow = "follow";
$metaImageSrc = $imageFilmSerie;
$canonical = 'watch.php?id=' . $video->getId();
$CssStyle = "assets/style/style.css";
$script2 = " ";
$playerscript = '<script src="assets/js/videoplayer.js" defer></script>';
$script = " ";
$scriptJson = "<script type='application/ld+json'>
{
  '@context': 'https://schema.org',
  '@type': 'VideoObject',
  'name': `$titre`,
  'description': `$description`,
  'thumbnailUrl': 'https://metmatimaamar.com/entities/img/$imageFilmSerie',
  'uploadDate': '$uploadDate',
  'contentUrl': '$contentUrl'
}
</script>";
$content = ob_get_clean();
require_once("includes/header.php");


if (!isset($_GET["id"]) || empty($_GET["id"])) {
    ErrorMessage::show("Aucune vidéo trouvée");
    header('Location: accueil');
}

$user = new User($connection, $userLoggedIn);
$video = new Video($connection, $_GET["id"]);
$video->incrementViews();
$SrcImgSerieFilm = 'entities/img/' . $video->getThumbnail();
$upNextVideo = VideoProvider::getUpNext($connection, $video);
$entityVideoForUser = VideoProvider::getEntityVideoForUser($connection, $_GET["id"], $userLoggedIn);

?>
<div class="watchContainer paused" data-volume-level="high">
    <div class="videoControls watchNav"
        <?php
        if (!empty($userLoggedIn)) {
            echo 'onmousemove="startHideTimer()"';
        }
        ?>>
        <button class="iconButton" onclick="goBack()"><i class="fa-solid fa-chevron-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext" style="display:none">
        <button onclick="restartVideo()"><i class="fa-solid fa-rotate-right"></i></button>
        <div class="upNextContainer">
            <h2>Suivant:</h2>
            <h3><?php echo $upNextVideo->getTitle(); ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>

            <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>);"><i class="fa-solid fa-play"></i> Play</button>
        </div>
    </div>
    <img class="thumbnail-img">
    <div class="video-controls-container">
        <div class="timeline-container">
            <div class="timeline">
                <!--<img class="preview-img">-->
                <div class="thumb-indicator"></div>
            </div>
        </div>
        <div class="controls">
            <button class="play-pause-btn">
                <svg class="play-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
                </svg>
                <svg class="pause-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M14,19H18V5H14M6,19H10V5H6V19Z" />
                </svg>
            </button>
            <div style="display:flex;flex-grow:1;width:fit-content">
                <div class="volume-container">
                    <button class="mute-btn">
                        <svg class="volume-high-icon" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.84 14,18.7V20.77C18,19.86 21,16.28 21,12C21,7.72 18,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16C15.5,15.29 16.5,13.76 16.5,12M3,9V15H7L12,20V4L7,9H3Z" />
                        </svg>
                        <svg class="volume-low-icon" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M5,9V15H9L14,20V4L9,9M18.5,12C18.5,10.23 17.5,8.71 16,7.97V16C17.5,15.29 18.5,13.76 18.5,12Z" />
                        </svg>
                        <svg class="volume-muted-icon" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,4L9.91,6.09L12,8.18M4.27,3L3,4.27L7.73,9H3V15H7L12,20V13.27L16.25,17.53C15.58,18.04 14.83,18.46 14,18.7V20.77C15.38,20.45 16.63,19.82 17.68,18.96L19.73,21L21,19.73L12,10.73M19,12C19,12.94 18.8,13.82 18.46,14.64L19.97,16.15C20.62,14.91 21,13.5 21,12C21,7.72 18,4.14 14,3.23V5.29C16.89,6.15 19,8.83 19,12M16.5,12C16.5,10.23 15.5,8.71 14,7.97V10.18L16.45,12.63C16.5,12.43 16.5,12.21 16.5,12Z" />
                        </svg>
                    </button>
                    <input class="volume-slider" type="range" min="0" max="1" step="any" value="1">
                </div>
                <div class="duration-container">
                    <div class="current-time">0:00</div>
                    /
                    <div class="total-time"></div>
                </div>
            </div>
            <button class="speed-btn wide-btn">x1</button>
            <button class="mini-player-btn">
                <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zm-10-7h9v6h-9z" />
                </svg>
            </button>
            <button class="theater-player-btn">
                <svg class="tall" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 6H5c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 10H5V8h14v8z" />
                </svg>
                <svg class="wide" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 7H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 8H5V9h14v6z" />
                </svg>
            </button>
            <button class="fullscreen-player-btn">
                <svg class="open" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
                </svg>
                <svg class="close" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                </svg>
            </button>
        </div>
    </div>
    <video poster="<?= $SrcImgSerieFilm ?>" onended="showUpNext()">
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
    <?php if (!empty($userLoggedIn)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
            });
        </script>
    <?php endif; ?>
</div>
<div class="DescriptionVideoContainer">
    <div class="subshare-video-metmati">
        <a href="https://www.facebook.com/sharer.php?u=<?php echo 'https://metmatimaamar.com/watch.php?id=' . $video->getId() ?>&t=<?php echo $video->getTitle(); ?>" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://t.me/share/url?url=<?php echo 'https://metmatimaamar.com/watch.php?id=' . $video->getId(); ?>&text=<?php echo $video->getTitle(); ?>" target="_blank"><i class="fab fa-telegram"></i></a>
        <a href="https://twitter.com/share?url=https://metmatimaamar.com/watch.php?id=<?= $video->getSlugVideo() ?>&amp;text=<?= $video->getTitle() ?>&amp;hashtags=islam" target="_blank"><i class="fab fa-fab fa-twitter"></i></a>
    </div>
    <div class="infoRow">
        <h2>Infos</h2>
        <p class="infos">Durée : <?= $video->getDuration() ?></p>
        <p class="infos view">
            <?php
            if ($video->getViews() == 0 || $video->getViews() == 1) {
                echo $video->getViews() . ' vue';
            } else if ($video->getViews() >= 1) {
                echo $video->getViews() . ' vues';
            }
            ?>
        </p>
        <?php
        if ($video->isMovie()) {
            echo '<p class="infos season hidden">' . $video->getSeasonAndEpisode() . '</p>';
        } else {
            echo '<p class="infos season">' . $video->getSeasonAndEpisode() . '</p>';
        }
        ?>
    </div>
    <div class="infoRow headline">
        <img class="miniPicture" src="<?= $SrcImgSerieFilm ?>" alt="<?= $video->getTitle() ?>">
        <p><?= $video->getDescription() ?></p>
    </div>
</div>
<footer>
    <?php
    if (!empty($userLoggedIn)) {
        echo "<div class='connexion'><i class='fa-solid fa-circle connecte'></i><p class='footer'>Salam Aleykoum <span>" . $user->getPrenom() . '<span> Bon Visionnage</p></div>';
    }
    ?>
    <div class="section5">
        <div itemscope itemtype="https://schema.org/Organization" id="contact" class="col">
            <span itemprop="url" content="https://metmatimaamar.com"><a href=""><img class="logo" itemprop="logo" src="assets/images/logo.png" class="logo" alt=""></a></span>
            <p><strong><span itemprop="name">Maamar Metmati</span></strong> | <span itemprop="alternateName">Metmati Maamar TV</span></p>

            <h4>Contactez-Nous</h4>
            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <p><strong><span itemprop="addresseLocality"></span>Adresse : </strong>Paris</p>
            </div>
            <p><strong>Téléphone : </strong><span itemprop="telephone">(+33) 7 86 02 69 24</span></p>
            <p><strong>Mail : </strong><span itemprop="email">metmati12@hotmail.fr</span></p>
            <p><strong>Horaires : </strong>10h00 - 20h00 du Lundi au Vendredi</p>
        </div>
        <div class="follow">
            <h4>Suivez-nous, c'est par ici !</h4>
            <div itemscope itemtype="https://schema.org/Organization" class="icon">
                <a itemprop="sameAs" href="https://www.facebook.com/MaamarMetmatiOfficiel" target="_blank"><i class="fa-brands fa-facebook fa-shake"></i></a>
                <a itemprop="sameAs" href="https://www.youtube.com/c/MaamarMetmatiOfficiel12" target="_blank"><i class="fa-brands fa-youtube fa-beat-fade"></i></a>
                <a itemprop="sameAs" href="https://www.instagram.com/maamarmetmati" target="_blank"><i class="fa-brands fa-instagram fa-bounce"></i></a>
                <a itemprop="sameAs" href="https://twitter.com/OfficielMaamar" target="_blank"><i class="fa-brands fa-twitter fa-spin fa-spin-reverse"></i></a>
                <a itemprop="sameAs" href="https://t.me/maamarmetmati" target="_blank"><i class="fa-brands fa-telegram fa-bounce"></i></a>
                <a itemprop="sameAs" href="https://www.tiktok.com/@maamarmetmati" target="_blank"><i class="fa-brands fa-tiktok fa-bounce"></i></a>
            </div>
        </div>
        <div class="col">
            <h4>À mon propos</h4>
            <a href="https://maamarmetmati.fr/presentation-maamar-metmati">À propos de l'éditeur : Maamar Metmati</a>
        </div>
        <div class="col">
            <a href="https://maamarmetmati.fr/livres">Tout savoir sur nos livres</a>
            <h4>Nos Articles</h4>
            <a href="https://maamarmetmati.fr/articles" target="_blank">Pour lire nos articles</a>
            <a href="https://www.youtube.com/c/MaamarMetmatiOfficiel12" target="_blank">Sur Youtube</a>
            <a href="https://www.facebook.com/MaamarMetmatiOfficiel" target="_blank">Sur Facebook</a>
            <a href="https://t.me/maamarmetmati" target="_blank">Sur Telegram</a>
        </div>
        <div class="siteInternet">
            <a class="p21" href="https://maamarmetmati.fr">maamarmetmati.fr</a>
            <a class="p21" href="https://tarawih.com">tarawih.com</a>
            <a class="p21" href="https://tarawih.fr">tarawih.fr</a>
            <a class="p21" href="https://tarawih.eu">tarawih.eu</a>
            <a class="p12" href="https://laprieredetarawih.com">laprieredetarawih.com</a>
            <a class="p12" href="https://laprieredetarawih.net">laprieredetarawih.net</a>
            <a class="p12" href="https://laprieredetarawih.fr">laprieredetarawih.fr</a>
            <a class="p12" href="https://laprieredetarawih.eu">laprieredetarawih.eu</a>
            <a class="p12" href="https://laprieredetarawih.org">laprieredetarawih.org</a>
            <a class="p12" href="https://prieredetarawih.com">prieredetarawih.com</a>
            <a class="p12" href="https://prieredetarawih.eu">prieredetarawih.eu</a>
            <a class="p12" href="https://prieredetarawih.fr">prieredetarawih.fr</a>
            <a class="p12" href="https://prieredetarawih.net">prieredetarawih.net</a>
            <a class="p12" href="https://prieredetarawih.site">laprieredetarawih.site</a>
            <a class="p12" href="https://tarawih.info">tarawih.info</a>
        </div>
    </div>
    <div class="copyright">
        <p>Copyright @2023 <i id="common" class="fab fa-creative-commons"></i> - metmatimaamar.com - Créé par عبد الرحمن</p>
        <i class="fab fa-fab fa-html5"></i>
        <i class="fab fa-fab fa-css3-alt"></i>
        <i class="fab fa-fab fa-js"></i>
        <i class="fab fa-fab fa-php"></i>
    </div>
</footer>
</body>

</html>