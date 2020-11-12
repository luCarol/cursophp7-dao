<?php

class Sql extends PDO {

    private $connection;

    public function __construct() {

        $this->connection = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");

    }

    private function setParams($stmt, $parameters = array()) {

        foreach ($parameters as $key => $value) {
            
            $stmt->setParam($key, $value);

        }

    }

    private function setParam($stmt, $key, $value) {

        $stmt->bindParam($key, $value);

    }

    public function query($rawQuery, $params = array()) {

        $statement = $this->connection->prepare($rawQuery);

        
        $this->setParams($statement, $params);
            
        $statement->execute();

        return $statement;

    }

    public function select($rawQuery, $params = array()):array {
            
        $statement = $this->query($rawQuery, $params);
    
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>