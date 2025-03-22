<?php
require_once("../includes/config.php");

if (isset($_POST["videoId"]) && isset($_POST["pseudo"])) {
    $query = $connection->prepare("SELECT progress FROM videoProgress WHERE pseudo=:pseudo AND videoId=:videoId");
    $query->bindValue(":pseudo", $_POST["pseudo"]);
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();
    echo $query->fetchColumn();

}
else{
    echo "Aucune Vidéo";
}