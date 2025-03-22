<?php
class PreviewProvider
{

    private $connection;
    private $pseudonyme;

    public function __construct($connection, $pseudonyme)
    {
        $this->connection = $connection;
        $this->pseudonyme = $pseudonyme;
    }

    public function createCategoryPreviewVideo($categoryId)
    {
        $entitiesArray = EntityProvider::getEntities($this->connection, $categoryId, 1);

        if (sizeof($entitiesArray) == 0) {
            ErrorMessage::show("Aucune Catégorie à afficher");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createSeriesPreviewVideo()
    {
        $entitiesArray = EntityProvider::getSeriesEntities($this->connection, null, 1);

        if (sizeof($entitiesArray) == 0) {
            ErrorMessage::show("Aucune Série à afficher");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createFilmPreviewVideo()
    {
        $entitiesArray = EntityProvider::getFilmsEntities($this->connection, null, 1);

        if (sizeof($entitiesArray) == 0) {
            ErrorMessage::show("Aucun Film à afficher");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createPreviewVideo($entity)
    {
        if ($entity == null) {
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        // $thumbnail = $entity->getThumbnail();

        $videoId = VideoProvider::getEntityVideoForUser($this->connection, $id, $this->pseudonyme);
        $video = new Video($this->connection, $videoId);
        $isInProgress = $video->isInProgress($this->pseudonyme);
        $stillWatching = $video->stillWatching($this->pseudonyme);
        $hasSeen = $video->hasSeen($this->pseudonyme);

        $playButtontext = "";
        if ($isInProgress) {
            $playButtontext = "Continuer à regarder";
        } else if ($stillWatching) {
            $playButtontext = "Poursuivre Encore et encore";
        } else if ($hasSeen) {
            $playButtontext = "Regarder de nouveau";
        } else {
            $playButtontext = "Regarder";
        }
        $SrcImgSerieFilm = 'entities/img/' . $video->getThumbnail();
        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";
        $subDescriptif = $this->createDescriptifSerieFilm($entity);

        return "<div class='previewContainer'>
            <img src='$SrcImgSerieFilm' class='previewImage' hidden>

            <video autoplay muted class='previewVideo'onended='previewEnded()'>
                <source src='$preview' type='video/mp4'>
            </video>
            <div class='previewOverlay'>
                <div class='mainDetails'>
                    <h3>$name</h3>
                    $subHeading
                    $subDescriptif
                    <div class='buttons'>
                        <button onclick='watchVideo($videoId)'><i class='fa-sharp fa-solid fa-play'></i> $playButtontext</button>
                        <button onclick='volumeToggle(this)'><i class='fa-sharp fa-solid fa-volume-xmark'></i></button>
                    </div>
                </div>
            </div>


        </div>";
    }

    public function createDescriptifSerieFilm($entity)
    {
        $descriptif = $entity->getDescriptifSerieFilm();

        if (empty($descriptif)) {
            return "";
        } else {
            return "<h4 class='descriptif'>$descriptif</h4>";
        }
    }

    public function createEntityPreviewSquare($entity)
    {
        $id = $entity->getId();
        $name = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        $slug = $entity->getSlugEntity();
        $videoId = VideoProvider::getEntityVideoForUser($this->connection, $id, $this->pseudonyme);
        $video = new Video($this->connection, $videoId);
        $srcImg = 'entities/img/' . $thumbnail;
        if ($video->isInProgress($this->pseudonyme) || $video->hasSeen($this->pseudonyme) || $video->stillWatching($this->pseudonyme)) {
            return "<a href='entite-$id-$slug'>
            <div class='previewWrapper small color'>
                <img src='$srcImg' title='$name'>
                <p>$name</p>
            </div>
            </a>";
        } else {
            return "<a href='entite-$id-$slug'>
            <div class='previewWrapper small'>
                <img src='$srcImg' title='$name'>
                <p>$name</p>
            </div>
            </a>";
        }
    }

    public function createEntityTitlePreviewSquare($entity)
    {
        $id = $entity->getId();
        $name = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        $slug = $entity->getSlugEntity();
        $videoId = VideoProvider::getEntityVideoForUser($this->connection, $id, $this->pseudonyme);
        $video = new Video($this->connection, $videoId);
        $srcImg = 'entities/img/' . $thumbnail;

        if ($video->isInProgress($this->pseudonyme) || $video->hasSeen($this->pseudonyme) || $video->stillWatching($this->pseudonyme)) {
            return "<a href='entite-$id-$slug'>
            <div class='previewWrapper small color'>
                <img src='$srcImg' title='$name'>
                <p>$name</p>
            </div>
            </a>";
        } else {
            return "<a href='entite-$id-$slug'>
            <div class='previewWrapper small'>
                <img src='$srcImg' title='$name'>
                <p>$name</p>
            </div>
            </a>";
        }
    }

    private function getRandomEntity()
    {

        $entity = EntityProvider::getEntities($this->connection, null, 1);
        return $entity[0];
    }
}
