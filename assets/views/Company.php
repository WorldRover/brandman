<?php
$this->company = new Company($this->db,$this->contentsObject["id"],$this->contentsObject["name"],$this->contentsObject["min_date"]);
$companyResults = $this->company->buildCompany();
$this->contents1 = $companyResults[0];
$this->contents2 = $this->contentsObject["name"];
$this->contents3 = (substr($this->contentsObject["min_date"],0,4)-TIMELINE_MIN_YEAR)*YEARWIDTH;
$this->contents4 = (TIMELINE_MAX_YEAR-substr($this->contentsObject["min_date"],0,4)+1)*YEARWIDTH;
$this->contents5 = $companyResults[1];
$this->contents6 = $companyResults[2];
$this->contents7 = $companyResults[3];
?>