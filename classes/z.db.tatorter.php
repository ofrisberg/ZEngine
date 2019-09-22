<?php

class ZTatorter extends ManageDB implements iEntity{
	
	public function selfName(){return "Tätort";}
	public function selfNamePlural(){return "Tätorter";}
	public function selfUrl(){return "tatort";}
	public function selfUrlPlural(){return "tatorter";}
	
	public function selfTable(){return "z_tatorter";}
	public function selfColId(){return "id";}
	public function selfColName(){return "name";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>