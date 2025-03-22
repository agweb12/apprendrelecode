<?php
class SeasonProvider{
    private $connection, $pseudonyme;

    public function __construct($connection,$pseudonyme){
        $this->connection = $connection;
        $this->pseudonyme = $pseudonyme;
    }

    public function create($entity){
        $seasons = $entity->getSeasons();

        if(sizeof($seasons) == 0){
            return;
        }
        $seasonsHtml = "";
        foreach($seasons as $season){
            $seasonNumber = $season->getSeasonNumber() . "<br>";
            $videosHtml = "";

            foreach($season->getVideos() as $video){
                $videosHtml .= $this->createVideoSquare($video);
            }
            $verifCategory = $entity->getCategoryId();
            $verifCategory = $verifCategory != 3 ? "Série " : "Juz' ";

            $seasonsHtml .= "<div class='season'><h3>";
            $seasonsHtml .= $verifCategory;
            $seasonsHtml .= "$seasonNumber</h3><div class='videos'>$videosHtml</div></div>";
        }

        return $seasonsHtml;
    }

    public function vueVideo($entity){
        $vue = $this->dejaVue($entity);
        return $vue;
    }

    private function dejaVue($video){
        $dejaVue = $video->hasSeen($this->pseudonyme) ? "<div class='alreadyView'><i class='fa-solid fa-circle-check dejavue'></i><p class='deja'>Déjà vue</p></div>" : "" ;
        return $dejaVue;
    }

    private function createVideoSquare($video){
        $id = $video->getId();
        $name = $video->getTitle();
        $duration = $video->getDuration();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();
        $slugVideo = $video->getSlugVideo();
        $isInProgress = $video->isInProgress($this->pseudonyme);
        $stillWatching = $video->stillWatching($this->pseudonyme);
        $hasSeen = $video->hasSeen($this->pseudonyme);
        $iconStillWatching = $stillWatching ? "<i class='fa-solid fa-circle-play iconWatching'></i>" : "";
        $iconContinuer = $isInProgress ? "<i class='fa-solid fa-circle-play iconContinuer'></i>" : "";
        $iconHasSeen = $hasSeen ? "<i class='fa-solid fa-circle-check seen'></i>" : "";

        $continuerRegarder ="";
        if($isInProgress){
            $continuerRegarder = "<span class='tooltiptext continuer' id='right'>Continuer</span>";
        } else if ($stillWatching){
            $continuerRegarder = "<span class='tooltiptext continuer' id='right'>Regarder Encore</span>";
        } else if ($hasSeen){
            $continuerRegarder = "<span class='tooltiptext continuer' id='right'>New Watch</span>";
        } else {
            $continuerRegarder = "<span class='tooltiptext' id='right'>Regarder</span>" ;
        }
        $SrcImgSerieFilm = 'entities/img/'.$video->getThumbnail();


        return "<div class='episodeContainer'>
                        <div class='contents'>
                            <p class='episodeNumber'>$episodeNumber</p>
                            $iconHasSeen
                            $iconContinuer
                            $iconStillWatching
                            <img src='$SrcImgSerieFilm'>
                            <div class='videoInfo'>
                                <p class='pDuration'>Durée : $duration<a href='watch.php?id=$id'><span class='tooltiptext continuer' id='right'>$continuerRegarder</span></a></p>
                                <h4>$name</h4>
                                <p class='description'>$description</p>
                            </div>
                        </div>
                    </div>";

    }
}