<?php
class Timeline {
	
	private $db;
	private $companyID;
	private $results;
	private $company_results;
	private $i;
	private $companies = Array();
	private $min_date;
	
	public function __construct(PDO $db, $companyID) {
		$this->db = $db;
		if($companyID) {
			$this->companyID = $companyID;
		} else {
			$this->companyID = NULL;
		}
	}
	
	public function buildTimeline() {
	    $query = $this->db->prepare('SELECT *, MIN(e.date) AS min_date FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID GROUP BY c.companyID');
		$query->execute(array('id' => $this->companyID));
		
		$this->results = NULL;
		$this->i = 0;
		while($row = $query->fetch()) {
			$this->company_results = Array("id" => $row["companyID"],"name" => $row["name"],"min_date" => $row["min_date"]);
			
			//! SETUP VIEW
			$this->companies[$this->i] = new View($this->db,"Company",$this->company_results);
			$this->results .= $this->companies[$this->i]->buildView();
			$this->company_results = NULL;
			$this->i++;
		}
		return $this->html_generateTimeline($this->results);
	}
	
	private function html_generateTimeline($timelineContents) {
		$html_timelineContents = $timelineContents;
		return $html_timelineContents;
	}
}
?>