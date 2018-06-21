<?php

class ZTekniskfysik extends ManageDB implements iEntity{
	
	public function selfName(){return "Teknisk fysik";}
	public function selfUrl(){return "tekniskfysik";}
	
	public function selfTable(){return "z_tekniskfysik";}
	public function selfColId(){return "tf_url";}
	public function selfColName(){return "tf_title";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>