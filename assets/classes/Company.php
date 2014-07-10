<?php
class Company {
	
	protected $db;
	private $companyID;
	private $companyName;
	private $company_results;
	private $brand_results;
	private $results;
	private $companyMinDate;

	public function __construct(PDO $db, $companyID, $companyName, $companyMinDate) {
		$this->db = $db;
		$this->companyID = $companyID;
		$this->companyName = $companyName;
		$this->companyMinDate = $companyMinDate;
	}
	
	public function buildCompany() {
	    $query = $this->db->prepare('SELECT *, MIN(e.date) AS min_date FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN brands b ON ed.brandID = b.brandID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID WHERE c.companyID = :companyID GROUP BY e.eventID');
		$query->bindParam(":companyID",$this->companyID);
		$query->execute();

		$this->company_results .= $this->companyID;

		$this->results = NULL;
		$this->i = 0;
		while($row = $query->fetch()) {
//			$this->companies[$this->i] = new Company($this->db, $row["companyID"]);
//			$this->company_results .= $this->companies[$this->i]->buildCompany($row["companyID"]);
			$this->brand_results = Array("id" => $row["brandID"],"name" => $row["name"],"min_date" => $row["min_date"],"parent_min_date" => $this->companyMinDate);
			//! SETUP VIEW
			$brand_view = new View($this->db,"Brand",$this->brand_results);
			$this->results .= $brand_view->buildView();
//			$this->company_results = NULL;
		}
		return $this->html_generateCompany($this->results);
	}
	
	public function html_generateCompany($companyDetails) {
		return $companyDetails;
//		$companyView = new View($this->db, "Company");
//		return $companyView->buildView();
	}
}
?>