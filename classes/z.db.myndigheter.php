<?php

class ZMyndigheter extends ManageDB implements iEntity{
	
	public function selfName(){return "Myndighet";}
	public function selfNamePlural(){return "Myndigheter";}
	public function selfUrl(){return "myndighet";}
	public function selfUrlPlural(){return "myndigheter";}
	
	public function selfTable(){return "z_myndigheter";}
	public function selfColId(){return "org_nr";}
	public function selfColName(){return "namn";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>