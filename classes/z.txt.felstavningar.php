<?php

class ZFelstavningar extends ManageTXT implements iEntity{
	
	public function selfName(){return "Felstavning";}
	public function selfNamePlural(){return "Felstavningar";}
	public function selfUrl(){return "felstavning";}
	public function selfUrlPlural(){return "felstavningar";}
	public function selfFile(){return "felstavningar.txt";}
	public function selfTotColumns(){return 2;}
	
	public function splitLine($line){ 
		$arr = explode('->',$line);
		foreach ($arr as &$v){
			$v = trim($v);
		}
		return $arr;
	}
	
	public function trimLine($line){
		$str = trim($line, "\r\n");
		return utf8_encode($str);
	}
	
	public function toLink(){
		$fel = $this->getName();
		$ratt = $this->getAttributes()['1']['value'];
		return "$fel (= $ratt)";
	}
		
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>