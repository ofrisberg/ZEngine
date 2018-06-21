<?php

class ZBerzan extends ManageDB implements iEntity{
	
	public function selfName(){return "Berzan";}
	public function selfUrl(){return "berzan";}
	
	public function selfTable(){return "z_berzan";}
	public function selfColId(){return "url";}
	public function selfColName(){return "title";}
	
	public function searchByName($name){ 
		global $DB;
		$name = $DB->real_escape_string($name);
		$query = $DB->query("SELECT * FROM ".$this->selfTable()." WHERE ".$this->selfColName()." LIKE '$name%' LIMIT 1");
		if($query->num_rows == 0){
			throw new Exception("Couldnt find row");
		}
		$this->loadAttributes($query->fetch_assoc());
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>