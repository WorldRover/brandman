<?php
class Timeline {
	
	protected $db;
	private $companyID;
	
	public function __construct(PDO $db, $companyID) {
		$this->db = $db;
		if($companyID) {
			$this->companyID = $companyID;
		} else {
			$this->companyID = NULL;
		}
	}
	
	public function buildTimeline() {
	    $query = $this->db->prepare('SELECT * FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN brands b ON ed.brandID = b.brandID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID;');
	    $query->execute(array('id' => $this->companyID));
	 
	    while($row = $query->fetch()) {
	        $results .= serialize($row);
	    }
		return "TIMELINE: " . $results;
	}
}
?>