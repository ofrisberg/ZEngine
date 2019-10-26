<?php

class ZVarldsarv extends ManageTXT implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Världsarv";}
	public function selfUrl(){return "varldsarv";}
	public function selfFile(){return "varldsarv.txt";}
	public function selfColName(){return "4";}
	public function selfColId(){return "5";}
	public function selfTotColumns(){return 6;}
		
	public function splitLine($line){
		$arr = explode("\t", trim($line));
		foreach ($arr as &$v){
			$v = trim($v);
		}
		return $arr;
	}
	
	public function toLink(){
		$namn = $this->getName();
		$land = $this->getAttributes()['0']['value'];
		if($this->hasPage()){
			return "<a href='/z/".$this->selfUrlPlural()."/".$this->getId()."/'>$namn</a> ($land)";
		}
		return "$namn ($land)";
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}

?>