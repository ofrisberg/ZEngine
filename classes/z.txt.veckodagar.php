<?php

class ZVeckodagar extends ManageTXT implements iEntity{
	
	public function selfName(){return "Veckodag";}
	public function selfNamePlural(){return "Veckodagar";}
	public function selfUrl(){return "veckodagar";}
	public function selfFile(){return "veckodagar.txt";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}

?>