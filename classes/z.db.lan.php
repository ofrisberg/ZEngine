<?php

class ZLan extends ManageDB implements iEntity{
	
	public function selfName(){return "Län";}
	public function selfNamePlural(){return "Län";}
	public function selfUrl(){return "lan";}
	public function selfUrlPlural(){return "lan";}
	
	public function selfTable(){return "z_lan";}
	public function selfColId(){return "id";}
	public function selfColName(){return "title";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>