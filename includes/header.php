<?php
require_once('includes/classes/PreviewProvider.class.php');
require_once('includes/classes/CategoryContainers.class.php');
require_once('includes/classes/EntityProvider.class.php');
require_once('includes/classes/ErrorMessage.class.php');
require_once('includes/classes/SeasonProvider.class.php');
require_once('includes/classes/Season.class.php');
require_once('includes/classes/VideoProvider.class.php');
require_once('includes/classes/User.class.php');

$userLoggedIn = $_SESSION['userLoggedIn'];

if (empty($userLoggedIn)) {
    $userLoggedIn = "";
} else {
    $userLoggedIn = $_SESSION['userLoggedIn'];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "kj52t86pzf");
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FEQ55N7FPL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FEQ55N7FPL');
    </script>
    <!-- END GOOGLE TAG -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="<?= $metaIndex . ',' . $metaFollow ?>">
    <title><?= $metaTitle ?></title>
    <meta name="description" content="<?= substr($metaDescription, 0, 150) . ' [...]' ?>">
    <meta name="twitter:image" content="https://metmatimaamar.com/entities/img/<?= $metaImageSrc ?>">
    <meta name="twitter:description" content="<?= $metaDescription ?>">
    <meta name="facebook-domain-verification" content="st8u236704bffrw1xreqtkwvy98hm7" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MaamarMetmati">
    <meta name="twitter:creator" content="@MaamarMetmati">
    <meta name="twitter:title" content="<?= $metaTitle ?>">

    <meta property="og:title" content="<?= $metaTitle ?>" />
    <meta property="og:description" content="<?= $metaDescription ?>" />
    <meta keywords="<?= $metaKeywords ?>" />
    <meta property="og:image" content="https://metmatimaamar.com/entities/img/<?= $metaImageSrc ?>" />
    <meta property="og:site_name" content="Metmati Maamar" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.metmatimaamar.com/<?= $canonical ?>" />

    <meta name="fragment" content="!">
    <link rel="image_src" href="https://metmatimaamar.com/entities/img/<?= $metaImageSrc ?>">
    <link rel="canonical" href="https://www.metmatimaamar.com/<?= $canonical ?>">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" type="text/css" href="<?= $CssStyle ?>">
    <script src="https://kit.fontawesome.com/b83fa86058.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <?php
    if ($script2 !== "") {
        echo $playerscript;
    } else {
        "";
    }
    ?>
    <script src="assets/js/script.js" defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <?php
    if ($script !== "") {
        echo $scriptJson;
    } else {
        "";
    }
    ?>
</head>

<body>
    <?php
    if (!isset($hideNav)) {
        include_once("includes/navBar.php");
    }
    ?>
    <?php echo $content; ?>