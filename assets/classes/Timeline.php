<?php
class Timeline {
	
	private $companyID;
	
	public function __construct($companyID) {
		if($companyID) {
			$this->companyID = $companyID;
		} else {
			$this->companyID = NULL;
		}
	}
	
	public function buildTimeline() {
		//TODO: Add functionality here.
		return "TIMELINE";
	}
}
?>