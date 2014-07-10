<?php
$companyID = (isset($_GET["companyID"]) ? $_GET["companyID"] : "");
$timeline = new Timeline($this->db,$companyID);
$this->contents1 = $timeline->buildTimeline();
?>