<?php

class ZYrken extends ManageTXT implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Yrke";}
        public function selfNamePlural(){return "Yrken";}
	public function selfUrl(){return "yrken";}
	public function selfFile(){return "yrken.txt";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }
}

?>