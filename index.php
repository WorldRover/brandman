<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("config.php");

function __autoload($class_name) {
    include "assets/classes/" . $class_name . ".php";
}

require_once("assets/languages/" . LANGUAGE . ".php");

$page = new Page("1");
echo $page->buildPage();
?>