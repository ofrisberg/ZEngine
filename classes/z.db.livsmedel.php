<?php

class ZLivsmedel extends ManageDB implements iEntity{
	
	public function selfName(){return "Livsmedel";}
	public function selfUrl(){return "livsmedel";}
	
	public function selfTable(){return "z_livsmedel";}
	public function selfColId(){return "Livsmedelsnummer";}
	public function selfColName(){return "Livsmedelsnamn";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>