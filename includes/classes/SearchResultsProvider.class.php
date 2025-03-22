<?php
class SearchResultsProvider{
    private $connection, $pseudonyme;

    public function __construct($connection, $pseudonyme){
        $this->connection = $connection;
        $this->pseudonyme = $pseudonyme;
    }

    public function getResults($inputText){
        $entities = EntityProvider::getSearchEntities($this->connection, $inputText);

        $html = "<div class='previewCategories noScroll'>";
        $html .= $this->getResultHtml($entities);

        return $html . "</div>";
    }

    private function getResultHtml($entities){
        if(sizeof($entities) == 0){
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->connection, $this->pseudonyme);
        foreach($entities as $entity){
            $entitiesHtml .= $previewProvider->createEntityTitlePreviewSquare($entity);
        }

        return "<div class='category'>
                    <div class='entities'>
                        $entitiesHtml
                    </div>
            </div>";
    }
}