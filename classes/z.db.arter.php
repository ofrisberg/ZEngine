<?php

class ZArter extends ManageDB implements iEntity{
	
	public function selfName(){return "Art";}
	public function selfNamePlural(){return "Arter";}
	public function selfUrl(){return "art";}
	public function selfUrlPlural(){return "arter";}
	
	public function selfTable(){return "z_arter";}
	public function selfColId(){return "TaxonId";}
	public function selfColName(){return "Svenskt_namn";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>