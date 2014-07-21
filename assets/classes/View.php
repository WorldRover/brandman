<?php
class View {
	
	protected $db;
	private $viewID;
	private $contentFile;
	private $contents1;
	private $contents2;
	private $contents3;
	private $contents4;
	private $contents5;
	private $contents6;
	private $contents7;
	private $contentsObject;
	
	public function __construct($db,$viewID,$contentsObject = NULL) {
		$this->db = $db;
		$this->viewID = $viewID;
		$this->contentsObject = $contentsObject;
	}
	
	public function buildView() {
		$this->contentFile = file_get_contents("assets/templates/" . $this->viewID . ".phtml");
		require("assets/views/" . $this->viewID . ".php");
		$this->contentFile = str_replace("[[CONTENTS1]]",$this->contents1,$this->contentFile);
		$this->contentFile = str_replace("[[CONTENTS2]]",$this->contents2,$this->contentFile);
		$this->contentFile = str_replace("[[CONTENTS3]]",$this->contents3,$this->contentFile);
		$this->contentFile = str_replace("[[CONTENTS4]]",$this->contents4,$this->contentFile);
		$this->contentFile = str_replace("[[CONTENTS5]]",$this->contents5,$this->contentFile);
		$this->contentFile = str_replace("[[CONTENTS6]]",$this->contents6,$this->contentFile);
		$this->contentFile = str_replace("[[CONTENTS7]]",$this->contents7,$this->contentFile);
		return $this->contentFile;
	}
}
?>