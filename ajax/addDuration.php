<?php
require_once("../includes/config.php");


if (isset($_POST["videoId"]) && isset($_POST["pseudo"])) {
    $query = $connection->prepare("SELECT * FROM videoProgress WHERE pseudo=:pseudo AND videoId=:videoId");
    $query->bindValue(":pseudo", $_POST["pseudo"]);
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();

    if($query->rowcount() == 0){
        $query = $connection->prepare("INSERT INTO videoProgress(pseudo, videoId) VALUES (:pseudo, :videoId)");

        $query->bindValue(":pseudo", $_POST["pseudo"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->execute();
    }
}
else{
    echo "Aucune vidéo ou pseudo reconnu";
}