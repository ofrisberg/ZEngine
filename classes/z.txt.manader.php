<?php

class ZManader extends ManageTXT implements iEntity{
	
	public function selfName(){return "Månad";}
	public function selfNamePlural(){return "Månader";}
	public function selfUrl(){return "manader";}
	public function selfFile(){return "manader.txt";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}

?>