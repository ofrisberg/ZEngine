<?php

class ZElements extends ManageDB implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Grundämne";}
	public function selfNamePlural(){return "Grundämnen";}
	public function selfUrl(){return "grundamne";}
	public function selfUrlPlural(){return "grundamnen";}
	
	public function selfTable(){return "z_elements";}
	public function selfColId(){return "Atomic_Number";}
	public function selfColName(){return "Name_Swedish";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>