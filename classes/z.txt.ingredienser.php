<?php

class ZIngredienser extends ManageTXT implements iEntity{
	
	public function selfName(){return "Ingrediens";}
	public function selfNamePlural(){return "Ingredienser";}
	public function selfUrl(){return "ingrediens";}
	public function selfUrlPlural(){return "ingredienser";}
	public function selfFile(){return "ingredienser.csv";}
	public function selfTotColumns(){return 2;}
	
	public function toLink(){ 
		$str = $this->getName();
		$str .= " (".$this->getAttributes()[1][value].")";
		return $str; 
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}





?>