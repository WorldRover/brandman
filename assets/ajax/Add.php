<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../../config.php");

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DB, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

function __autoload($class_name) {
    include "../../assets/classes/" . $class_name . ".php";
}

require_once("../../assets/languages/" . LANGUAGE . ".php");

@extract($_GET);

if ($addType == "company") {

	$company = new Company($db,NULL,$inputCompany,$companyStartDate,NULL);
	$companyCreation = $company->createCompany();

	if ($companyCreation) {
		echo '{"responseData":{"result":"success","companyID":"' . $company->companyID . '","companyName":"' . $company->companyName . '"}}';
	} else {
		echo '{"responseData":{"result":"fail","companyID":""}}';
	}
}

if ($addType == "brand") {

	$brand = new Brand($db,NULL,$inputBrand,$brandStartDate,$inputCompanyID);
	$brandCreation = $brand->createBrand();

	if ($brandCreation) {
		echo '{"responseData":{"result":"success","brandID":"' . $brand->brandID . '","brandName":"' . $brand->brandName . '"}}';
	} else {
		echo '{"responseData":{"result":"fail","brandID":""}}';
	}
}
?>