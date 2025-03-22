<?php
class Account
{

    private $connection;
    private $erreurTableau = array();

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function updateDetails($p, $n, $em, $ps)
    {
        $this->validatePrenom($p);
        $this->validateNom($n);
        $this->validateNewEmail($em, $ps);

        if (empty($this->erreurTableau)) {
            $query = $this->connection->prepare("UPDATE users SET prenom=:p, nom=:n, email=:em
                                                WHERE pseudo=:ps");
            $query->bindValue(":p", $p);
            $query->bindValue(":n", $n);
            $query->bindValue(":em", $em);
            $query->bindValue(":ps", $ps);

            return $query->execute();
        }
        return false;
    }

    public function inscription($p, $n, $ps, $em, $em2, $pw, $pw2)
    {
        $this->validatePrenom($p);
        $this->validateNom($n);
        $this->validatePseudo($ps);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        if (empty($this->erreurTableau)) {
            return $this->insertUserDetails($p, $n, $ps, $em, $pw);
        }

        return false;
    }

    public function login($ps, $pw)
    {
        $pw = hash("sha512", $pw);

        $query = $this->connection->prepare('SELECT * FROM users WHERE pseudo=:ps AND motdepasse=:pw');

        $query->bindValue(":ps", $ps);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        }

        array_push($this->erreurTableau, Constants::$loginFailed);
        return false;
    }

    private function insertUserDetails($p, $n, $ps, $em, $pw)
    {

        $pw = hash("sha512", $pw);

        $query = $this->connection->prepare('INSERT INTO users (prenom,nom,pseudo,email,motdepasse,date_token,motdepasse_token) 
        VALUES (:p,:n,:ps,:em,:pw,NULL,"")');

        $query->bindValue(":p", $p);
        $query->bindValue(":n", $n);
        $query->bindValue(":ps", $ps);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        return $query->execute();
    }

    private function validatePrenom($p)
    {
        if (strlen($p) < 2 || strlen($p) > 25) {
            array_push($this->erreurTableau, Constants::$prenomCaracteres);
        }
    }

    private function validateNom($n)
    {
        if (strlen($n) < 2 || strlen($n) > 25) {
            array_push($this->erreurTableau, Constants::$nomCaracteres);
        }
    }

    private function validatePseudo($ps)
    {
        if (strlen($ps) < 2 || strlen($ps) > 25) {
            array_push($this->erreurTableau, Constants::$pseudoCaracteres);
            return;
        }
        $query = $this->connection->prepare('SELECT * FROM users WHERE pseudo=:ps');
        $query->bindValue(':ps', $ps);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->erreurTableau, Constants::$pseudoPris);
        }
    }

    private function validateEmails($em, $em2)
    {
        if ($em != $em2) {
            array_push($this->erreurTableau, Constants::$emailsDontMatch);
            return;
        }

        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->erreurTableau, Constants::$emailInvalid);
            return;
        }

        $query = $this->connection->prepare('SELECT * FROM users WHERE email=:em');
        $query->bindValue(':em', $em);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->erreurTableau, Constants::$emailPris);
            return;
        }
    }

    private function validateNewEmail($em, $ps)
    {

        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->erreurTableau, Constants::$emailInvalid);
            return;
        }

        $query = $this->connection->prepare("SELECT * FROM users WHERE email=:em AND pseudo != :ps");
        $query->bindValue(":em", $em);
        $query->bindValue(":ps", $ps);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->erreurTableau, Constants::$emailPris);
            return;
        }
    }

    private function validatePasswords($pw, $pw2)
    {
        if ($pw != $pw2) {
            array_push($this->erreurTableau, Constants::$passwordsDontMatch);
            return;
        }
        if (strlen($pw) < 12 || strlen($pw) > 300) {
            array_push($this->erreurTableau, Constants::$passwordCaracteres);
        }
    }

    public function getError($erreur)
    {
        if (in_array($erreur, $this->erreurTableau)) {
            return "<span class='erreurMessage'>$erreur</span>";
        }
    }

    public function getPremiereErreur()
    {
        if (!empty($this->erreurTableau)) {
            return $this->erreurTableau[0];
        }
    }

    public function updatePassword($oldPw, $pw, $pw2, $ps)
    {
        $this->validateOldPassword($oldPw, $ps);
        $this->validatePasswords($pw, $pw2);

        if (empty($this->erreurTableau)) {
            $query = $this->connection->prepare("UPDATE users SET motdepasse=:pw WHERE pseudo=:ps");
            $pw = hash("sha512", $pw);
            $query->bindValue(":pw", $pw);
            $query->bindValue(":ps", $ps);

            return $query->execute();
        }

        return false;
    }

    public function validateOldPassword($oldPw, $ps)
    {
        $pw = hash("sha512", $oldPw);

        $query = $this->connection->prepare('SELECT * FROM users WHERE pseudo=:ps AND motdepasse=:pw');

        $query->bindValue(":ps", $ps);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if ($query->rowCount() == 0) {
            array_push($this->erreurTableau, Constants::$motdepasseIncorrect);
        }
    }
}
