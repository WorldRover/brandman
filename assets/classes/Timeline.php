<?php
class Timeline {
	
	private $companyID;
	
	public function __construct($companyID) {
		$this->companyID = $companyID;
	}
	
	public function buildTimeline() {
		return "TIMELINE";
	}
}
?>