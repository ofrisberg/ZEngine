<?php

class ZSporter extends ManageTXT implements iEntity{
	
	public function selfName(){return "Sporter";}
	public function selfUrl(){return "sporter";}
	public function selfFile(){return "sporter.txt";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>