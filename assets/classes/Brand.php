<?php
class Brand {
	
	protected $db;
	private $brandID;
	private $brand_results;

	public function __construct(PDO $db, $brandID) {
		$this->db = $db;
		$this->brandID = $brandID;
	}
	
	public function buildBrand() {
	    $query = $this->db->prepare('SELECT * FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN brands b ON ed.brandID = b.brandID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID WHERE b.brandID = :brandID');
		$query->bindParam(":brandID",$this->brandID);
		$query->execute();

		$this->brand_results = NULL;
		$this->i = 0;
		while($row = $query->fetch()) {
//			$this->companies[$this->i] = new Company($this->db, $row["companyID"]);
//			$this->company_results .= $this->companies[$this->i]->buildCompany($row["companyID"]);
//			$this->company_results = $row["companyID"];
			//! SETUP VIEW
//			$company_view = new View($this->db,"Company",$this->company_results);
//			$this->results .= $company_view->buildView();
//			$this->company_results = NULL;
			$this->brand_results .= $row["brandID"];
		}
		return $this->html_generateBrand($this->brand_results);
	}
	
	public function html_generateBrand($brandDetails) {
		return $brandDetails;
//		$companyView = new View($this->db, "Company");
//		return $companyView->buildView();
	}
}
?>