<?php
class DatabaseHelper
{
    public static function createConnection($values = array())
    {
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
    public static function runQuery($connection, $sql, $parameters = array())
    {
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }
        $statement = null;
        if (count($parameters) > 0) {
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
           if (! $executedOk) {throw new PDOException;}
        } else {
            $statement = $connection->query($sql);
            if (!$statement) {throw new PDOException;}
        }
        return $statement;
    }
} 

class GalleriesDB
{
    private static $baseSQL = "SELECT * FROM galleries";
    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    public function getPainting($paintingID)
    {
        $sql = self::$baseSQL . " WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($paintingID));
        return $statement->fetchAll();
    }
    public function getGallery($paintingID)
    {
        $sql = self::$baseSQL . " WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($paintingID));
        return $statement->fetch();
    }
}

class PaintingsDB
{
    private static $baseSQL = "SELECT * FROM paintings";
    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getGalleryPaintings($galleryID)
    {
        $sql = "SELECT * FROM paintings WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($galleryID));
        return $statement->fetchAll();
    }
}

class CustomerLoginDB {
    private static $baseSQL = "SELECT CustomerID, UserName, Pass FROM customerlogon";
    
    public function __construct($connection) {
        $this->pdo = $connection;
    }
    public function getUserName($userName) {
        $sql = self::$baseSQL . " WHERE UserName=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($userName));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    private static function getPaintingSQL()
    {
        $sql = "SELECT PaintingID, Paintings.ArtistID AS ArtistID, FirstName, LastName, GalleryID, ImageFileName, Title, ShapeID, MuseumLink, AccessionNumber, CopyrightText, Description, Excerpt, YearOfWork, Width, Height, Medium, Cost, MSRP, GoogleLink, GoogleDescription, WikiLink, JsonAnnotations FROM Paintings INNER JOIN Artists ON Paintings.ArtistID = Artists.ArtistID  ";
        return $sql;
    }

    private static function getFavPaintingSQL($pID)
    {
        $sql = "SELECT ImageFileName, Title, PaintingID FROM Paintings WHERE PaintingID=$pID";
        return $sql;
    }
    public function getFavPainting($paintingID)
    {
        $sql = self::getFavPaintingSQL($paintingID);
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function getPainting($PaintID)
    {
        $sql = "SELECT *, CONCAT(ImageFileName,'.jpg') as FullImageFileName FROM paintings WHERE PaintingID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($PaintID));
        return $statement->fetch();
    }

}
class ArtistDB
{
    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getArtist($artistID)
    {
        $sql = "SELECT * FROM artists WHERE ArtistID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($artistID));
        return $statement->fetch();
    }
}
?>