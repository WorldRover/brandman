<?php
$this->company = new Company($this->db,$this->contentsObject["id"],$this->contentsObject["name"],$this->contentsObject["min_date"]);
$this->contents1 = $this->company->buildCompany();
$this->contents2 = $this->contentsObject["name"];
$this->contents3 = (substr($this->contentsObject["min_date"],0,4)-1800)/5;
?>