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
		
		return $baseFile;
	}
}
?>