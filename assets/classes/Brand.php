<?php
class Brand {
	
	protected $db;
	public $brandID;
	public $brandName;
	private $brand_results;
	private $brand_results1;
	private $brand_results2;
	private $brand_results3;
	private $brandStartDate;
	private $parentCompanyID;

	public function __construct(PDO $db, $brandID, $brandName, $brandStartDate = NULL, $parentCompanyID = NULL) {
		$this->db = $db;
		$this->brandID = $brandID;
		$this->brandName = $brandName;
		$this->brandStartDate = $brandStartDate;
		$this->parentCompanyID = $parentCompanyID;
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

	private function colorPalette($imageFile, $numColors, $granularity = 5) 
	{ 
	   $granularity = max(1, abs((int)$granularity)); 
	   $colors = array(); 
	   $size = @getimagesize($imageFile); 
	   if($size === false) 
	   { 
	      user_error("Unable to get image size data"); 
	      return false; 
	   } 
	   $img = @imagecreatefromjpeg($imageFile); 
	   if(!$img) 
	   { 
	      user_error("Unable to open image file"); 
	      return false; 
	   } 
	   for($x = 0; $x < $size[0]; $x += $granularity) 
	   { 
	      for($y = 0; $y < $size[1]; $y += $granularity) 
	      { 
	         $thisColor = imagecolorat($img, $x, $y); 
	         $rgb = imagecolorsforindex($img, $thisColor); 
	         $red = round(round(($rgb['red'] / 0x33)) * 0x33);  
	         $green = round(round(($rgb['green'] / 0x33)) * 0x33);  
	         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);  
	         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue); 
	         if(array_key_exists($thisRGB, $colors)) 
	         { 
	            $colors[$thisRGB]++; 
	         } 
	         else 
	         { 
	            $colors[$thisRGB] = 1; 
	         } 
	      } 
	   } 
	   arsort($colors); 
	   return array_slice(array_keys($colors), 0, $numColors); 
	} 

	public function RGBToHex($r,$g,$b) {
		//String padding bug found and the solution put forth by Pete Williams (http://snipplr.com/users/PeteW)
		$hex = "#";
		$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
 
		return $hex;
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
//			$colors_array = Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
//			$colors_array2 = Array("F","E","D","C","B","A","9","8","7","6","5","4","3","2","1","0");
//			$this->brand_results1 = $colors_array[(ltrim($row["brandID"],"0")*1 ? )].$colors_array2[ltrim($row["brandID"],"0")*2].$colors_array[ltrim($row["brandID"],"0")*3].$colors_array2[ltrim($row["brandID"],"0")*4].$colors_array[ltrim($row["brandID"],"0")*5].$colors_array2[ltrim($row["brandID"],"0")*6];
//			$this->brand_results1 = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);

			// sample usage: 
//			$palette = $this->colorPalette('../images/logo.png', 10, 4); 
//			echo "<table>\n"; 
//			foreach($palette as $color) 
//			{ 
//			   echo "<tr><td style='background-color:#$color;width:2em;'>&nbsp;</td><td>#$color</td></tr>\n"; 
//			} 
//			echo "</table>\n";

//			$this->brand_results1 = str_pad(substr(dechex(ltrim($row["brandID"],"0")*2),0,2),2,"0").str_pad(substr(dechex(ltrim($row["brandID"],"0")*3),-2),2,"0").str_pad(substr(dechex(ltrim($row["brandID"],"0")*4),0,2),2,"0");
			$number1 = (ltrim($row["brandID"],"0")*(ltrim($row["brandID"],"0") % 2 == 0 ? 2 : 37));
			$number1 = str_pad($number1 <= 255 ? $number1 : substr(ltrim($row["brandID"],"0")*(ltrim($row["brandID"],"0") % 3 == 0 ? 5 : 29),0,2),2,"0");
			$number2 = (ltrim($row["brandID"],"0")*(ltrim($row["brandID"],"0") % 4 == 0 ? 11 : 19));
			$number2 = str_pad($number2 <= 255 ? $number2 : substr(ltrim($row["brandID"],"0")*(ltrim($row["brandID"],"0") % 5 == 0 ? 13 : 17),0,2),2,"0");
			$number3 = (ltrim($row["brandID"],"0")*(ltrim($row["brandID"],"0") % 6 == 0 ? 7 : 23));
			$number3 = str_pad($number3 <= 255 ? $number3 : substr(ltrim($row["brandID"],"0")*(ltrim($row["brandID"],"0") % 7 == 0 ? 3 : 31),0,2),2,"0");
			$this->brand_results1 =  $number1 . "," . $number2 . "," . $number3;

			if ($this->get_brightness($this->RGBToHex($number1,$number2,$number3)) > 130) // will have to experiment with this number
				$this->brand_results2 = "000000";
			else 
				$this->brand_results2 = "FFFFFF";
			
			$this->brand_results3 = $row["companyID"];
		}
		return $this->html_generateBrand($this->brand_results,$this->brand_results1,$this->brand_results2,$this->brand_results3);
	}
	
	public function html_generateBrand($brandDetails,$brandDetails1,$brandDetails2,$brandDetails3) {
		$html_brandcontents = Array($brandDetails,$brandDetails1,$brandDetails2,$brandDetails3);
		return $html_brandcontents;
//		$companyView = new View($this->db, "Company");
//		return $companyView->buildView();
	}


	public function createBrand() {
	    $query = $this->db->prepare('INSERT INTO brands SET notes = :brandName;');
		$query->bindParam(":brandName",$this->brandName);
		$query->execute();
		$this->brandID = $this->db->lastInsertId();

	    $query = $this->db->prepare('INSERT INTO events SET date = :brandStartDate, operationID = "00000003";');
		$query->bindParam(":brandStartDate",$this->brandStartDate);
		$query->execute();
		$eventID = $this->db->lastInsertId();

	    $query = $this->db->prepare('INSERT INTO names SET name = :brandName;');
		$query->bindParam(":brandName",$this->brandName);
		$query->execute();
		$nameID = $this->db->lastInsertId();

	    $query = $this->db->prepare('INSERT INTO event_details SET eventID = :eventID, brandID = :brandID, companyID = :companyID, nameID = :nameID, percentOwned = "1";');
		$query->bindParam(":eventID",$eventID);
		$query->bindParam(":brandID",$this->brandID);
		$query->bindParam(":companyID",$this->parentCompanyID);
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