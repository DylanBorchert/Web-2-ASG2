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
            if (!$executedOk) {
                throw new PDOException;
            }
        } else {
            $statement = $connection->query($sql);
            if (!$statement) {
                throw new PDOException;
            }
        }
        return $statement;
    }
}

class GalleriesDB
{
    private static $baseSQL = "SELECT * FROM Galleries";
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
    private static $baseSQL = "SELECT * FROM Paintings";
    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getGalleryPaintings($galleryID)
    {
        $sql = "SELECT *, CONCAT(ImageFileName,'.jpg') as FullImageFileName FROM Paintings LEFT JOIN Artists ON paintings.ArtistID = artists.ArtistID WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($galleryID));
        return $statement->fetchAll();
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
        $sql = "SELECT *, CONCAT(ImageFileName,'.jpg') as FullImageFileName FROM Paintings WHERE PaintingID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($PaintID));
        return $statement->fetch();
    }
    public function returnSearch($sql)
    {
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    public function getAllForArtist($artistID)
    {
        $sql = self::$baseSQL . " WHERE Paintings.ArtistID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array(
            $artistID
        ));
        return $statement->fetchAll();
    }
    public function getAllForGallery($galleryID)
    {
        $sql = self::$baseSQL . " WHERE Paintings.GalleryID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array(
            $galleryID
        ));
        return $statement->fetchAll();
    }
    public function getTop15()
    {
        $sql = self::$baseSQL . " ORDER BY YearOfWork LIMIT 15";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    public function getTop20()
    {
        $sql = self::$baseSQL . " ORDER BY YearOfWork LIMIT 20";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    public function getforTitle($paintingTitle)
    {
        $sql = self::$baseSQL . " WHERE Paintings.Title=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array(
            $paintingTitle
        ));
        return $statement->fetchAll();
    }
    public function getAllForArtistandEraMayLike($artist, $yearS, $yearE)
    {
        $sql = self::$baseSQL . " WHERE Paintings.ArtistID = ? OR (Paintings.YearOfWork > ? AND Paintings.YearOfWork < ?) LIMIT 15";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array(
            $artist,
            $yearS,
            $yearE
        ));
        return $statement->fetchAll();
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
    public function getAllArtist()
    {
        $sql = "SELECT * FROM artists";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class CustomerLoginDB
{
    private static $baseSQL = "SELECT CustomerID, UserName, Pass FROM CustomerLogon";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getUserName($userName)
    {
        $sql = self::$baseSQL . " WHERE UserName=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($userName));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

class CustomerInfoDB
{
    private static $baseSQL = "SELECT FirstName, LastName, City, Country FROM Customers";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }
    public function getCustomerInfo($userID)
    {
        $sql = self::$baseSQL . " WHERE CustomerID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($userID));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
