<?php
require_once("config.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

function __autoload($class_name) {
    include "assets/classes/" . $class_name . ".php";
}

$page = new Page("1");
echo $page->buildPage();
?>