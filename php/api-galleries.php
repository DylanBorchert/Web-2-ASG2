<?php
require_once 'config.inc.php';

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new PaintingDB($conn);
    $paintings = $gateway->getAll();
    echo json_encode($paintings, JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    die($e->getMessage());
}
