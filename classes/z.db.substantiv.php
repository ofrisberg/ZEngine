<?php

class ZSubstantiv extends ManageDB implements iEntity{
	
	public function selfName(){return "Substantiv";}
	public function selfUrl(){return "substantiv";}
	
	public function selfTable(){return "z_sv_substantiv";}
	public function selfColId(){return "id";}
	public function selfColName(){return "sing_obes";}
	
	public function searchByName($name){ 
		global $DB;
		$name = $DB->real_escape_string($name);
		$sql = "SELECT * FROM ".$this->selfTable()." WHERE ".$this->selfColName()." LIKE '$name%'";
		$sql .= " OR ".$this->selfColName()." LIKE 'en $name%' OR ".$this->selfColName()." LIKE 'ett $name%' LIMIT 1";
		$query = $DB->query($sql);
		if($query->num_rows == 0){
			throw new Exception("Couldnt find row");
		}
		$this->loadAttributes($query->fetch_assoc());
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>