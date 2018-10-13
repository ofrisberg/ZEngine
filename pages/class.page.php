<?php

class Page extends Template{
	
	function __construct() {
		parent::__construct();
		
		$this->setAppName("ZDB");
		
		$this->addMenuLink("ZDB","");
		$this->addMenuLink("Listor","/z/");
		$this->addMenuLink("Projekt","/p/");
		
		$this->addFooterItem("ZDB © ".date('Y'));
		$this->addFooterItem("<a href='/om-webbplatsen/'>Om webbplatsen</a>");
    }
	public function getLogoLink(){ 
		$value="";
		if(isset($_POST["z_question"])){$value=$_POST["z_question"];}
		$out = '<span class="w3-bar-item w3-padding-small" style="margin-top:3px;"><form action="/" method="post">';
		$out .= '<input name="z_question" autocomplete="off" id="z_question" placeholder="Sök" value="'.$value.'" class="w3-input w3-padding-small" style="width:180px;height:36px;font-size:14px;" type="search"/>';
		$out .= '</form></span>';
		return $out;
	}
	
	public static function onNotFound(){
		http_response_code(404);
		require '404.php';
		exit();
	}
	
	
}



?>