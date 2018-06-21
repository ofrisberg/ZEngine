<?php

class ZKommuner extends ManageDB implements iEntity{
	
	public function selfName(){return "Kommun";}
	public function selfNamePlural(){return "Kommuner";}
	public function selfUrl(){return "kommun";}
	public function selfUrlPlural(){return "kommuner";}
	
	public function selfTable(){return "z_kommuner";}
	public function selfColId(){return "id";}
	public function selfColName(){return "title";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>