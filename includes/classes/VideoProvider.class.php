<?php
class VideoProvider{
    public static function getUpNext($connection, $currentVideo){
        $query = $connection->prepare("SELECT * FROM videos WHERE entityId=:entityId AND id != :videoId 
        AND ((season = :season AND episode > :episode) OR season > :season) ORDER BY season, episode ASC LIMIT 1");
        $query->bindValue(":entityId", $currentVideo->getEntityId());
        $query->bindValue(":season", $currentVideo->getSeasonNumber());
        $query->bindValue(":episode", $currentVideo->getEpisodeNumber());
        $query->bindValue(":videoId", $currentVideo->getId());

        $query->execute();

        if($query->rowCount() == 0){
            $query = $connection->prepare("SELECT * FROM videos WHERE season <= 1 AND episode <= 1 AND id != :videoId ORDER BY views DESC LIMIT 1");
            $query->bindValue(":videoId", $currentVideo->getId());
            $query->execute();
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return new Video($connection, $row);
    }

    public static function getEntityVideoForUser($connection, $entityId, $pseudonyme){
        $query = $connection->prepare("SELECT videoId FROM videoProgress 
                                    INNER JOIN videos ON videoProgress.videoId = videos.id
                                    WHERE videos.entityId = :entityId
                                    AND videoProgress.pseudo = :pseudo
                                    ORDER BY videoProgress.dateModified DESC
                                    LIMIT 1");
        $query->bindValue(":entityId", $entityId);
        $query->bindValue(":pseudo", $pseudonyme);
        $query->execute();

        if($query->rowCount() == 0) {
            $query = $connection->prepare("SELECT id FROM videos
                                            WHERE entityId=:entityId
                                            ORDER BY season, episode ASC LIMIT 1");
            $query->bindValue(":entityId", $entityId);
            $query->execute();

        }
        return $query->fetchColumn();
    }
}