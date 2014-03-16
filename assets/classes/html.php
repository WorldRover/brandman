<?php
class Event {
	
	protected $db;
	private $eventID;
	private $date;
	private $operationID;
	private $operationName;
	private $brands = Array();
	private $companies = Array();
	private $names = Array();
	
	public function __construct($db,$eventID) {
		$this->db = $db;
		$this->eventID = $eventID;
	
		$query = $this->db->prepare('SELECT * FROM events e LEFT JOIN restructure_operations ro ON e.operationID = ro.operationID LEFT JOIN event_details ed ON e.eventID = ed.eventID LEFT JOIN brands b ON ed.brandID = b.brandID LEFT JOIN companies c ON ed.companyID = c.companyID LEFT JOIN names n ON ed.nameID = n.nameID;');
	    $query->execute(array('id' => $this->companyID));
	 
	    while($row = $query->fetch()) {
	        $contents .= "<div>";
	    }
		
	}
	
	public function buildView() {
		$this->contentFile = file_get_contents("assets/templates/" . $this->viewID . ".phtml");
		require_once("assets/views/" . $this->viewID . ".php");
		return str_replace("[[CONTENTS]]",$this->contents,$this->contentFile);
	}
}

/*<html>
	<head>
		<title>BrandMan - DRZiegler.net</title>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.css" />
<!--		<link rel="stylesheet" type="text/css" href="assets/css/default.css" />-->
	</head>
	<body>
		<div id='head'>
			<img src='assets/images/logo.png' alt='BrandMan - Brand Guide'>
			<?php
			$topowner = mysql_fetch_array(mysql_query("SELECT * FROM owner_names WHERE ownerID = '" . $ownerID . "';"));
			echo "<h2>" . $topowner["name"] . "</h2>";
			?>
		</div>
		<div id='nav'>
			&nbsp;
		</div>
		<div id='contents'>
			<?php
			$brandquery = mysql_query("SELECT * FROM brands_to_owners bto LEFT JOIN brand_names bn ON bto.brandID = bn.brandID WHERE bto.ownerID = '" . $ownerID . "' AND bto.startDate < NOW() AND (bto.endDate > NOW() OR bto.endDate IS NULL) ORDER BY bto.startDate DESC;");
			while ($brand = mysql_fetch_array($brandquery)) {
				echo "<div class='brandbox'>";
				echo "<h3>" . $brand["name"] . "</h3>";
				$ownerquery = mysql_query("SELECT bto.ownerID, bto.startDate, bto.endDate, own.name FROM brands_to_owners bto LEFT JOIN owner_names own ON bto.ownerID = own.ownerID AND bto.endDate >= own.startDate AND (bto.startDate <= own.endDate OR own.endDate IS NULL) WHERE bto.brandID = '" . $brand["brandID"] . "' ORDER BY bto.startDate DESC;");
				while ($owner = mysql_fetch_array($ownerquery)) {
					$years = (($owner["endDate"] ? substr($owner["endDate"],0,4) : date("Y"))-substr($owner["startDate"],0,4));
					if ($ownerlist[$owner["ownerID"]]) {
						$color = $ownerlist[$owner["ownerID"]];
					} else {
						$arraymax = count($ownerlist);
						$ownerlist[$owner["ownerID"]] = $colors[$arraymax];
						$color = $colors[$arraymax];
						
					};
					echo "<div class='brand' style='width: " . ($years*6) . "; background-color: #" . $color . ";'><div class='yearstart'>" . substr($owner["startDate"],0,4) . "</div>" . $owner["name"] . "</div>";
				};
				echo "</div><hr class='clear' size='1'>";
			};
			?>
		</div>
		<script src="assets/js/bootstrap.js"></script>
	</body>
</html>*/
?>
