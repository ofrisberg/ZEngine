<?php

class ZRecept extends ManageTXT implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Recept";}
	public function selfUrl(){return "recept";}
	public function selfFile(){return "recept.csv";}
	public function selfTotColumns(){return 3;}
	
	public function selfListDescription(){ 
		return "Lista över dom 100 recept som har kortast tillagningstid."; 
	}

	public function toLink(){ 
		$url = $this->getAttributes()[1][value];
		$str = '<a href="'.$url.'">'.$this->getName().'</a>';
		$str .= " (".$this->getAttributes()[2][value]." minuter)";
		return $str; 
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}





?>