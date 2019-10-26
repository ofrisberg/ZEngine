<?php

class ZOrdsprak extends ManageTXT implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Ordspråk";}
	public function selfUrl(){return "ordsprak";}
	public function selfFile(){return "ordsprak.txt";}
	
	public function toLink(){
		$str = $this->getName();
		if(strpos($str,'(') !== false){$str = explode('(',$str)[0];}
		return $str;
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>