<?php
require_once("../includes/config.php");
require_once("../includes/classes/SearchResultsProvider.class.php");
require_once("../includes/classes/EntityProvider.class.php");
require_once("../includes/classes/Entity.class.php");
require_once("../includes/classes/Video.class.php");
require_once("../includes/classes/VideoProvider.class.php");
require_once("../includes/classes/PreviewProvider.class.php");

if (isset($_POST["term"]) && isset($_POST["pseudo"])) {
    $srp = new SearchResultsProvider($connection, $_POST["pseudo"]);
    echo $srp->getResults($_POST["term"]);
}
else{
    echo "Aucun terme ou identifiant de recherche reconnu";
}