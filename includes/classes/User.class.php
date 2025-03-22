<?php
class User
{
    private $connection, $sqlData;

    public function __construct($connection, $pseudonyme)
    {
        $this->connection = $connection;

        $query = $connection->prepare("SELECT * FROM users WHERE pseudo=:pseudo");
        $query->bindValue(":pseudo", $pseudonyme);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getPrenom()
    {
        return $this->sqlData["prenom"];
    }
    public function getNom()
    {
        return $this->sqlData["nom"];
    }
    public function getEmail()
    {
        return $this->sqlData["email"];
    }
}
