<?php

class ZCountries extends ManageDB implements iEntity{
	
	public function selfName(){return "Land";}
	public function selfNamePlural(){return "Länder";}
	public function selfUrl(){return "land";}
	public function selfUrlPlural(){return "lander";}
	
	public function selfTable(){return "z_countries";}
	public function selfColId(){return "id";}
	public function selfColName(){return "name";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>