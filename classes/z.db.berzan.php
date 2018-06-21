<?php

class ZBerzan extends ManageDB implements iEntity{
	
	public function selfName(){return "Berzan";}
	public function selfUrl(){return "berzan";}
	
	public function selfTable(){return "z_berzan";}
	public function selfColId(){return "url";}
	public function selfColName(){return "title";}
	public function selfListDescription(){ 
		return "Skolarbeten från Berzeliusskolan (gymnasium), 2011-2014."; 
	}
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>