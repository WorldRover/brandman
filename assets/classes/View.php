<?php
class View {
	
	protected $db;
	private $viewID;
	private $contentFile;
	private $contents;
	
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