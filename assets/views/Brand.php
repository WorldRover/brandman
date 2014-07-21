<?php
$this->brand = new Brand($this->db,$this->contentsObject["id"],$this->contentsObject["name"],$this->contentsObject["min_date"],$this->contentsObject["parent_min_date"]);
$brand_contents = $this->brand->buildBrand();
$this->contents1 = $brand_contents[0];
$this->contents2 = $this->contentsObject["name"];
$this->contents3 = (substr($this->contentsObject["min_date"],0,4)-substr($this->contentsObject["parent_min_date"],0,4))*YEARWIDTH;
$this->contents4 = (TIMELINE_MAX_YEAR-substr($this->contentsObject["min_date"],0,4)+1)*YEARWIDTH;
$this->contents5 = $brand_contents[1];
$this->contents6 = $brand_contents[2];
$this->contents7 = $brand_contents[3];
?>