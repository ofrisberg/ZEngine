<?php

class ZDatum extends ManageTXT implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Datum";}
	public function selfUrl(){return "datum";}
	public function selfFile(){return "datum.txt";}
	public function selfColName(){return "0";}
	public function selfColId(){return "0";}
	public function selfTotColumns(){return 2;}
		
	public function splitLine($line){
		$arr = explode("\t", trim($line));
		foreach ($arr as &$v){
			$v = trim($v);
		}
		return $arr;
	}
	
	public function toLink(){
		$datum = $this->getName();
		$text = $this->getAttributes()['1']['value'];
		return "$datum<span class='w3-small'><br>$text</span>";
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}

?>