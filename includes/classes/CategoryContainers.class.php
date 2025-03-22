<?php
class CategoryContainers{
    private $connection, $pseudonyme;

    public function __construct($connection,$pseudonyme){
        $this->connection = $connection;
        $this->pseudonyme = $pseudonyme;
    }

    public function showAllCategories(){
        $query = $this->connection->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        return $html . "</div>";
    }

    public function showSeriesCategories(){
        $query = $this->connection->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                <h1>Séries</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .= $this->getCategoryHtml($row, null, true, false);
        }


        return $html . "</div>";
    }

    public function showFilmsCategories(){
        $query = $this->connection->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                <h1>Interventions</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .= $this->getCategoryHtml($row, null, false, true);
        }


        return $html . "</div>";
    }


    public function showCategory($categoryId, $title = null){
        $query = $this->connection->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html = "<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .= $this->getCategoriesHtml($row, $title, true, true);
        }


        return $html . "</div>";
    }
    
    public function showAimerCategory($categoryId, $title = null){
        $query = $this->connection->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html = "<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .= $this->getAimerCategorie($row, $title, true, true);
        }


        return $html . "</div>";
    }

    private function getCategoryHtml($sqlData, $title, $series, $film){
        $categoryId = $sqlData["id"];
        $categorySlug = $sqlData["slug"];
        $title = $title == null ? $sqlData["nom"] : $title;

        if($series && $film){
            $entities = EntityProvider::getEntities($this->connection, $categoryId, 30);
        }
        else if($series){
            $entities = EntityProvider::getSeriesEntities($this->connection, $categoryId, 30);
        }
        else {
            $entities = EntityProvider::getFilmsEntities($this->connection, $categoryId, 30);
        }

        if(sizeof($entities) == 0){
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->connection, $this->pseudonyme);
        foreach($entities as $entity){
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <a href='categorie-$categoryId-$categorySlug'>
                        <h3>$title</h3>
                    </a>
                    <div class='miniWrapper'>
                        <div class='entities'>
                            $entitiesHtml
                        </div>
                    </div>
            </div>";
    }

    private function getCategoriesHtml($sqlData, $title, $series, $film){
        $categoryId = $sqlData["id"];
        $categorySlug = $sqlData["slug"];
        $title = $title == null ? $sqlData["nom"] : $title;

        if($series && $film){
            $entities = EntityProvider::getEntities($this->connection, $categoryId, 200);
        }
        else if($series){
            $entities = EntityProvider::getSeriesEntities($this->connection, $categoryId, 30);
        }
        else {
            $entities = EntityProvider::getFilmsEntities($this->connection, $categoryId, 30);
        }

        if(sizeof($entities) == 0){
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->connection, $this->pseudonyme);
        foreach($entities as $entity){
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <a href='categorie-$categoryId-$categorySlug'>
                        <h1>$title</h1>
                    </a>
                    <div class='miniWrapper'>
                        <div class='entities'>
                            $entitiesHtml
                        </div>
                    </div>
            </div>";
    }

    private function getAimerCategorie($sqlData, $title, $series, $film){
        $categoryId = $sqlData["id"];
        $categorySlug = $sqlData["slug"];
        $title = $title == null ? $sqlData["nom"] : $title;

        if($series && $film){
            $entities = EntityProvider::getEntities($this->connection, $categoryId, 10);
        }
        else if($series){
            $entities = EntityProvider::getSeriesEntities($this->connection, $categoryId, 10);
        }
        else {
            $entities = EntityProvider::getFilmsEntities($this->connection, $categoryId, 10);
        }

        if(sizeof($entities) == 0){
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->connection, $this->pseudonyme);
        foreach($entities as $entity){
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <a href='categorie-$categoryId-$categorySlug'>
                        <h3>$title</h3>
                    </a>
                    <div class='miniWrapper'>
                        <div class='entities'>
                            $entitiesHtml
                        </div>
                    </div>
            </div>";
    }
}