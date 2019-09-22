<?php

class ZOversatt extends ManageDB implements iEntity{
	
	public function selfName(){return "Översättning";}
	public function selfNamePlural(){return "Översättningar";}
	public function selfUrl(){return "oversattning";}
	public function selfUrlPlural(){return "oversattningar";}
	
	public function selfTable(){return "z_sv_oversatt";}
	public function selfColId(){return "id";}
	public function selfColName(){return "swedish";}
	
	public function hasPage(){ return false; }
	public function toLink(){
		$str = $this->getName();
		$str .= " ~ " . $this->getAttributes()['trans1']['value'];
		$str .= " (på " . $this->getAttributes()['lang_name']['value'].")";
		return $str;
	}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>