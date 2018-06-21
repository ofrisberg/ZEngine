<?php

class ZNamnsdagar extends ManageTXT implements iEntity{
	
	public function selfName(){return "Namnsdag";}
	public function selfNamePlural(){return "Namnsdagar";}
	public function selfUrl(){return "namnsdag";}
	public function selfUrlPlural(){return "namnsdagar";}
	public function selfFile(){return "namnsdagar.txt";}
	public function selfTotColumns(){return 2;}
	
	public function splitLine($line){ return explode("\t",$line);}
	
	public function toLink(){
		$namn = $this->getName();
		$dag = $this->getAttributes()['1']['value'];
		return "$namn - $dag";
	}
		
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>