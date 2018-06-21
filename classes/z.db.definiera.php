<?php

class ZDefiniera extends ManageDB implements iEntity{
	
	public function selfName(){return "Definiera";}
	public function selfUrl(){return "definiera";}
	
	public function selfTable(){return "z_definiera";}
	public function selfColId(){return "url";}
	public function selfColName(){return "ordet";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>