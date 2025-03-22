<?php
class Video{
    private $connection, $sqlData, $entity;

    public function __construct($connection, $input){
        $this->connection = $connection;

        if(is_array($input)){
            $this->sqlData = $input;
        } else{
            $query = $this->connection->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

        $this->entity = new Entity($connection, $this->sqlData["entityId"]);
    }

    public function getId(){return $this->sqlData["id"];}
    public function getTitle(){return $this->sqlData["title"];}
    public function getDescription(){return $this->sqlData["description"];}
    public function getFilePath(){return $this->sqlData["filePath"];}
    public function getUploadDate(){return $this->sqlData["uploadDate"];}
    public function getDuration(){return $this->sqlData["duration"];}
    public function getThumbnail(){return $this->entity->getThumbnail();}
    public function getEpisodeNumber(){return $this->sqlData["episode"];}
    public function getSeasonNumber(){return $this->sqlData["season"];}
    public function getEntityId(){return $this->sqlData["entityId"];}
    public function getViews(){return $this->sqlData["views"];}
    public function getSlugVideo(){return $this->sqlData["slug"];}


    public function incrementViews(){
        $query = $this->connection->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindValue(":id", $this->getId());
        $query->execute();
    }

    public function getSeasonAndEpisode(){
        if($this->isMovie()){
            return;
        }

        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();

        $verifEntityId = $this->getEntityId();
        if($verifEntityId != 106){
            return "Série $season, Episode $episode";
        } else if($verifEntityId == 106){
            return "Juz' $season, Sourate $episode";
        }

    }

    public function isMovie(){
        return $this->sqlData["isMovie"] == 1;
    }

    public function isInProgress($pseudonyme){
        $query = $this->connection->prepare("SELECT * FROM videoProgress
        WHERE videoId = :videoId AND pseudo = :pseudo 
        AND progress > 0 AND finished = 0");

        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":pseudo", $pseudonyme);
        $query->execute();

        return $query->rowCount() != 0;
    }

    public function stillWatching($pseudonyme){
        $query = $this->connection->prepare("SELECT * FROM videoProgress
        WHERE videoId = :videoId AND pseudo = :pseudo 
        AND progress > 0 AND finished = 1");

        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":pseudo", $pseudonyme);
        $query->execute();

        return $query->rowCount() != 0;
    }

    public function hasSeen($pseudonyme){
        $query = $this->connection->prepare("SELECT * FROM videoProgress
        WHERE videoId = :videoId AND pseudo = :pseudo 
        AND progress = 0 AND finished = 1");

        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":pseudo", $pseudonyme);
        $query->execute();

        return $query->rowCount() != 0;
    }
}