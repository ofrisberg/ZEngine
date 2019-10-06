<?php

class ZExoplaneter extends ManageDB implements iEntity{
	
	public function selfName(){return "Exoplanet";}
	public function selfNamePlural(){return "Exoplaneter";}
	public function selfUrl(){return "exoplanet";}
	public function selfUrlPlural(){return "exoplaneter";}
	
	public function selfTable(){return "z_exoplanets";}
	public function selfColId(){return "zdb_id";}
	public function selfColName(){return "NAME";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}