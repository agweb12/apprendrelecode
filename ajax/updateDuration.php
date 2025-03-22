<?php
require_once("../includes/config.php");


if (isset($_POST["videoId"]) && isset($_POST["pseudo"]) && isset($_POST["progress"])) {
    $query = $connection->prepare("UPDATE videoProgress SET progress=:progress,dateModified=NOW() WHERE pseudo=:pseudo AND videoId=:videoId");
    $query->bindValue(":pseudo", $_POST["pseudo"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":progress", $_POST["progress"]);

    $query->execute();

    if($query->rowcount() == 0){
        $query = $connection->prepare("INSERT INTO videoProgress(pseudo, videoId) VALUES (:pseudo, :videoId)");

        $query->bindValue(":pseudo", $_POST["pseudo"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->execute();
    }
}
else{
    echo "Aucune Vidéo";
}