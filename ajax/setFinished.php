<?php
require_once("../includes/config.php");


if (isset($_POST["videoId"]) && isset($_POST["pseudo"])) {
    $query = $connection->prepare("UPDATE videoProgress SET finished=1, progress=0 WHERE pseudo=:pseudo AND videoId=:videoId");
    $query->bindValue(":pseudo", $_POST["pseudo"]);
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();

}
else{
    echo "Aucune Vidéo";
}