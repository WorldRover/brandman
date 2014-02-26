<?php
class View {
	
	private $viewID;
	private $contentFile;
	
	public function __construct($viewID) {
		$this->viewID = $viewID;
	}
	
	public function buildView() {
		$this->contentFile = file_get_contents("assets/templates/" . $this->viewID . ".phtml");
		require_once("assets/views/" . $this->viewID . ".php");
		return str_replace("[[CONTENTS]]",$contents,$this->contentFile);
	}
}
?>