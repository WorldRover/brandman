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
	
	public function __construct($db,$viewID) {
		$this->db = $db;
		$this->viewID = $viewID;
	}
	
	public function buildView() {
		$this->contentFile = file_get_contents("assets/templates/" . $this->viewID . ".phtml");
		require_once("assets/views/" . $this->viewID . ".php");
		return str_replace("[[CONTENTS]]",$this->contents,$this->contentFile);
	}
}

?>