<?php
$companyID = ($_GET["companyID"] ? $_GET["companyID"] : "");
$timeline = new Timeline($this->db,$companyID);
$this->contents = $timeline->buildTimeline();
?>