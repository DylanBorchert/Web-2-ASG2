<?php
class DatabaseHelper {
    public static function createConnection( $values=array() ) {
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;
    }
    public static function runQuery($connection, $sql, $parameters=array()) {
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }
        $statement = null;
        if (count($parameters) > 0) {
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if (! $executedOk) throw new PDOException;
        } else {
            $statement = $connection->query($sql);
            if (!$statement) throw new PDOException;
        } 
        return $statement;
    }   
}

class GalleriesDB {
    private static $baseSQL = "SELECT * FROM galleries";
    public function __construct($connection) {
        $this->pdo = $connection;
    }
    public function getAll() {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    public function getPainting($paintingID) {
        $sql = "SELECT * FROM paintings WHERE PaintingID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($paintingID));
        return $statement->fetchAll();
    }
}

?>