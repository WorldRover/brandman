<?php
class Page {
	
	protected $db;
	private $pageID;
	private $viewID;

	public function __construct(PDO $db,$pageID,$viewID) {
		$this->db = $db;
		$this->pageID = $pageID;
		$this->viewID = $viewID;
	}

	public function buildPage() {
		//! GET BASE HTML
		$baseFile = file_get_contents("assets/templates/base.phtml");
		
		//! SETUP HEADER LINKS
		$header_links = "";
		$d = dir("assets/css/");
		while (false !== ($entry = $d->read())) {
			if ($entry != "." && $entry != "..") {
				$header_links .= '<link rel="stylesheet" type="text/css" href="assets/css/' . $entry . '" />';
			}
		}
		$d->close();

		$baseFile = str_replace("[[HTML_HEAD_LINKS]]",$header_links,$baseFile);
		
		//! SETUP SCRIPTS
		$scripts = "";
		$d = dir("assets/js/");
		while (false !== ($entry = $d->read())) {
			if ($entry != "." && $entry != "..") {
				$scripts .= '<script src="assets/js/' . $entry . '"></script>';
			}
		}
		$d->close();

		$baseFile = str_replace("[[HTML_BODY_SCRIPTS]]",$scripts,$baseFile);

		//! SETUP LANGUAGE DEFINITIONS
		$baseFile = str_replace("[[TEXT_TITLE]]",TEXT_BASE_TITLE,$baseFile);
		
		$baseFile = str_replace("[[TEXT_OPENNAV]]",TEXT_OPENNAV,$baseFile);
		
		$baseFile = str_replace("[[HTML_BODY_NAV_BRAND]]",HTML_BODY_NAV_BRAND,$baseFile);
		
		//! SETUP VIEW
		$view = new View($this->db,$this->viewID);
		$viewFile = $view->buildView();
		
		$baseFile = str_replace("[[HTML_BODY_CONTENTS]]",$viewFile,$baseFile);

		//! RETURN PAGE
		return $baseFile;
	}
}
?>