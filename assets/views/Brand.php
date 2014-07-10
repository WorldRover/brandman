<?php
$this->brand = new Brand($this->db,$this->contentsObject["id"],$this->contentsObject["name"],$this->contentsObject["min_date"],$this->contentsObject["parent_min_date"]);
$this->contents1 = $this->brand->buildBrand();
$this->contents2 = $this->contentsObject["name"];
$this->contents3 = (substr($this->contentsObject["min_date"],0,4)-substr($this->contentsObject["parent_min_date"],0,4))/5;
echo "(" . substr($this->contentsObject["min_date"],0,3) . "-" . substr($this->contentsObject["parent_min_date"],0,4) . ")/5\n";
?>