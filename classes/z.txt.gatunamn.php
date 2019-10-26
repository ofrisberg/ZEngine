<?php

class ZGatunamn extends ManageTXT implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Gatunamn";}
	public function selfUrl(){return "gatunamn";}
	public function selfFile(){return "gatunamn.txt";}
	
	
	
	public function trimLine($line){
		$name = trim($line, "\r\n");
		return utf8_encode($name);
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>