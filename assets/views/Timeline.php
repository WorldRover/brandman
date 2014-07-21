<?php
$companyID = (isset($_GET["companyID"]) ? $_GET["companyID"] : "");
$timeline = new Timeline($this->db,$companyID);
$timeline_contents = $timeline->buildTimeline(); 
$this->contents1 = $timeline_contents[0];
$this->contents2 = $timeline_contents[1];
$this->contents3 = $timeline_contents[2];
$this->contents4 = $timeline_contents[3];
?>