<?php

class ZForkortningar extends ManageTXT implements iEntity{
	
	public function selfName(){return "Förkortning";}
	public function selfNamePlural(){return "Förkortningar";}
	public function selfUrl(){return "forkortning";}
	public function selfUrlPlural(){return "forkortningar";}
	public function selfFile(){return "forkortningar.txt";}
	public function selfTotColumns(){return 2;}
	
	public function splitLine($line){ 
		$arr = explode('___',$line);
		foreach ($arr as &$v){
			$v = trim($v);
		}
		return $arr;
	}
	
	public function toLink(){
		$forkortning = $this->getName();
		$betydelse = $this->getAttributes()['1']['value'];
		return "$forkortning - $betydelse";
	}
		
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>