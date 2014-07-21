<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("config.php");

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DB, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

function __autoload($class_name) {
    include "assets/classes/" . $class_name . ".php";
}

require_once("assets/languages/" . LANGUAGE . ".php");

$page = new Page($db,"default","Timeline");
echo $page->buildPage();
?>