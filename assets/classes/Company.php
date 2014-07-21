<?php
class Company {
	
	protected $db;
	public $companyID;
	public $companyName;
	private $company_results;
	private $company_results1;
	private $company_results2;
	private $company_results3;
	private $brand_results;
	private $results;
	private $companyMinDate;
	private $companyMaxDate;

	public function __construct(PDO $db, $companyID, $companyName, $companyMinDate, $companyMaxDate = NULL) {
		$this->db = $db;
		$this->companyID = $companyID;
		$this->companyName = $companyName;
		$this->companyMinDate = $companyMinDate;
		$this->companyMaxDate = $companyMaxDate;
	}

	private function colourBrightness($hex, $percent) {
		// Work out if hash given
		$hash = '';
		if (stristr($hex,'#')) {
			$hex = str_replace('#','',$hex);
			$hash = '#';
		}
		/// HEX TO RGB
		$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
		//// CALCULATE 
		for ($i=0; $i<3; $i++) {
			// See if brighter or darker
			if ($percent > 0) {
				// Lighter
				$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
			} else {
				// Darker
				$positivePercent = $percent - ($percent*2);
				$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
			}
			// In case rounding up causes us to go to 256
			if ($rgb[$i] > 255) {
				$rgb[$i] = 255;
			}
		}
		//// RBG to Hex
		$hex = '';
		for($i=0; $i < 3; $i++) {
			// Convert the decimal digit to hex
			$hexDigit = dechex($rgb[$i]);
			// Add a leading zero if necessary
			if(strlen($hexDigit) == 1) {
			$hexDigit = "0" . $hexDigit;
			}
			// Append to the hex string
			$hex .= $hexDigit;
		}
		return $hash.$hex;
	}

	private function get_brightness($hex) {
		// returns brightness value from 0 to 255
		
		// strip off any leading #
		$hex = str_replace('#', '', $hex);
		
		$c_r = hexdec(substr($hex, 0, 2));
		$c_g = hexdec(substr($hex, 2, 2));
		$c_b = hexdec(substr($hex, 4, 2));
		
		return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
	}

	public function RGBToHex($r,$g,$b) {
		//String padding bug found and the solution put forth by Pete Williams (http://snipplr.com/users/PeteW)
		$hex = "#";
		$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
 
		return $hex;
	}

	public function buildCompany() {
	    $query = $this->db->prepare('SELECT *, MIN(e.date) AS min_date FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN brands b ON ed.brandID = b.brandID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID WHERE ro.operationID != "00000001" AND ro.operationID != "00000002" AND ro.operationID != "00000006" AND c.companyID = :companyID GROUP BY e.eventID');
		$query->bindParam(":companyID",$this->companyID);
		$query->execute();

		$this->company_results3 .= $this->companyID;


//		$this->company_results1 = $this->colourBrightness(str_pad(substr(dechex(ltrim($this->companyID,"0")*2),0,2),2,"0").str_pad(substr(dechex(ltrim($this->companyID,"0")*3),-2),2,"0").str_pad(substr(dechex(ltrim($this->companyID,"0")*4),0,2),2,"0"),"0.5");
//		$this->company_results1 = str_pad(substr(ltrim($this->companyID,"0"),0,2),2,"0") . "," . str_pad(substr(ltrim($this->companyID,"0"),0,2),2,"0") . "," . str_pad(substr(ltrim($this->companyID,"0"),0,2),2,"0");
		$number1 = (ltrim($this->companyID,"0")*(ltrim($this->companyID,"0") % 2 == 0 ? 2 : 37));
		$number1 = str_pad($number1 <= 255 ? $number1 : substr(ltrim($this->companyID,"0")*(ltrim($this->companyID,"0") % 3 == 0 ? 5 : 29),0,2),2,"0");
		$number2 = (ltrim($this->companyID,"0")*(ltrim($this->companyID,"0") % 4 == 0 ? 11 : 19));
		$number2 = str_pad($number2 <= 255 ? $number2 : substr(ltrim($this->companyID,"0")*(ltrim($this->companyID,"0") % 5 == 0 ? 13 : 17),0,2),2,"0");
		$number3 = (ltrim($this->companyID,"0")*(ltrim($this->companyID,"0") % 6 == 0 ? 7 : 23));
		$number3 = str_pad($number3 <= 255 ? $number3 : substr(ltrim($this->companyID,"0")*(ltrim($this->companyID,"0") % 7 == 0 ? 3 : 31),0,2),2,"0");
		$this->company_results1 =  $number1 . "," . $number2 . "," . $number3;

		if ($this->get_brightness($this->RGBToHex($number1,$number2,$number3)) > 130) // will have to experiment with this number

//		if ($this->get_brightness($this->company_results1) > 130) // will have to experiment with this number
			$this->company_results2 = "000000";
		else 
			$this->company_results2 = "FFFFFF";

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
		return $this->html_generateCompany($this->results,$this->company_results1,$this->company_results2,$this->company_results3);
	}
	
	public function html_generateCompany($companyDetails,$companyDetails1,$companyDetails2,$companyDetails3) {
		$company_return = Array($companyDetails,$companyDetails1,$companyDetails2,$companyDetails3);
		return $company_return;
//		$companyView = new View($this->db, "Company");
//		return $companyView->buildView();
	}
	
	public function createCompany() {
	    $query = $this->db->prepare('INSERT INTO companies SET notes = :companyName;');
		$query->bindParam(":companyName",$this->companyName);
		$query->execute();
		$this->companyID = $this->db->lastInsertId();

	    $query = $this->db->prepare('INSERT INTO events SET date = :companyMinDate, operationID = "00000006";');
		$query->bindParam(":companyMinDate",$this->companyMinDate);
		$query->execute();
		$eventID = $this->db->lastInsertId();

	    $query = $this->db->prepare('INSERT INTO names SET name = :companyName;');
		$query->bindParam(":companyName",$this->companyName);
		$query->execute();
		$nameID = $this->db->lastInsertId();

	    $query = $this->db->prepare('INSERT INTO event_details SET eventID = :eventID, companyID = :companyID, nameID = :nameID, percentOwned = "1";');
		$query->bindParam(":eventID",$eventID);
		$query->bindParam(":companyID",$this->companyID);
		$query->bindParam(":nameID",$nameID);
		$query->execute();
		$eventID = $this->db->lastInsertId();

		if($this->db->errorCode() != "00000") {
			return false;
		} else {
			return true;
		};
	}
}
?>