<?php
class Timeline {
	
	private $db;
	private $companyID;
	private $results1;
	private $results2;
	private $results3;
	private $results4;
	private $company_results;
	private $i;
	private $companies = Array();
	private $min_date;
	private $max_date;
	private $timeline_range;
	private $timeline;
	private $timeline_marks;
	
	public function __construct(PDO $db, $companyID) {
		$this->db = $db;
		if($companyID) {
			$this->companyID = $companyID;
		} else {
			$this->companyID = NULL;
		}
	}
	
	public function buildTimeline() {
		if (isset($this->companyID)) {
			$timeline_query = $this->db->prepare('SELECT MIN(e.date) AS timeline_min_date, MAX(e.date) AS timeline_max_date FROM events e LEFT JOIN event_details ed ON e.eventID = ed.eventID WHERE ed.companyID = :companyID GROUP BY ed.companyID;');
			$timeline_query->bindParam(":companyID",$this->companyID);
			$timeline_query->execute();
		} else {
			$timeline_query = $this->db->prepare('SELECT MIN(e.date) AS timeline_min_date, MAX(e.date) AS timeline_max_date FROM events e;');
			$timeline_query->bindParam(":companyID",$companyID);
			$timeline_query->execute();
		}
		$timeline_details = $timeline_query->fetch();
		$this->min_date = $timeline_details["timeline_min_date"];
		$this->max_date = "2014";
		define("TIMELINE_MIN_YEAR",$this->min_date);
		define("TIMELINE_MAX_YEAR","2014");
		$this->results4 = (TIMELINE_MAX_YEAR-TIMELINE_MIN_YEAR+1)*YEARWIDTH;

	    $query = $this->db->prepare('SELECT *, MIN(e.date) AS min_date FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID GROUP BY c.companyID');
		$query->execute(array('id' => $this->companyID));
		
		$this->results1 = NULL;
		$this->results2 = NULL;
		$this->results3 = NULL;
		$this->timeline_range = substr($this->max_date,0,4)-substr($this->min_date,0,4);

		$this->timeline .= "<div class='yearmark' style='width:" . YEARWIDTH . "px'><div class='yearmark_text'>" . substr($this->min_date,0,4) . "</div></div>";
		$this->timeline_marks .= (substr($this->min_date,0,4) % 5 == 1 ? "<div class='yearmark' style='width:" . YEARWIDTH . "px'>|</div>" : "<div class='yearmark' style='width:" . YEARWIDTH . "px'>.</div>");
		for ($j = (substr($this->min_date,0,4)+2); $j <= substr($this->max_date,0,4); $j++) {
			$this->timeline .= ($j % 5 == 1 ? "<div class='yearmark' style='width:" . YEARWIDTH . "px'><div class='yearmark_text'>" . $j . "</div></div>" : "<div class='yearblank' style='width:" . YEARWIDTH . "px'>&nbsp;</div>");
			$this->timeline_marks .= ($j % 5 == 1 ? "<div class='yearmark' style='width:" . YEARWIDTH . "px'>|</div>" : "<div class='yearmark' style='width:" . YEARWIDTH . "px'>.</div>");
		}
		$this->timeline_marks .= (substr($this->max_date,0,4) % 5 == 1 ? "<div class='yearmark' style='width:" . YEARWIDTH . "px'>|</div>" : "<div class='yearmark' style='width:" . YEARWIDTH . "px'>.</div>");
		$this->timeline .= "<div class='yearmark' style='width:" . YEARWIDTH . "px'><div class='yearmark_text'>" . substr($this->max_date,0,4) . "</div></div>";

		$this->results2 = $this->timeline;
		$this->results3 = $this->timeline_marks;

		$this->i = 0;
		while($row = $query->fetch()) {
			$this->company_results = Array("id" => $row["companyID"],"name" => $row["name"],"min_date" => $row["min_date"]);
			
			//! SETUP VIEW
			$this->companies[$this->i] = new View($this->db,"Company",$this->company_results);
			$this->results1 .= $this->companies[$this->i]->buildView();
			$this->company_results = NULL;
			$this->i++;
		}
		return $this->html_generateTimeline($this->results1,$this->results2,$this->results3,$this->results4);
	}
	
	private function html_generateTimeline($timelineContents1,$timelineContents2,$timelineContents3,$timelineContents4) {
		$html_timelineContents = Array($timelineContents1,$timelineContents2,$timelineContents3,$timelineContents4);
		return $html_timelineContents;
	}
}
?>