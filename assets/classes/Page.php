<?php
class Page {
	
	private $pageID;

	public function __construct($pageID) {
		$this->pageID = $pageID;
	}

	public function buildPage() {
		//! GET BASE HTML
		$baseFile = file_get_contents("assets/templates/base.html");
		
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

		//! SETUP LANGUAGE FILE
		$baseFile = str_replace("[[TEXT_TITLE]]",TEXT_BASE_TITLE,$baseFile);
		
		$baseFile = str_replace("[[TEXT_OPENNAV]]",TEXT_OPENNAV,$baseFile);
		
		$baseFile = str_replace("[[HTML_BODY_NAV_BRAND]]",HTML_BODY_NAV_BRAND,$baseFile);

		
		return $baseFile;
	}
}
?>