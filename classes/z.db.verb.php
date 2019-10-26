<?php

class ZVerb extends ManageDB implements iEntity{
	
        public function selfNamePrefix(){return "ett";}
	public function selfName(){return "Verb";}
	public function selfUrl(){return "verb";}
	
	public function selfTable(){return "z_sv_verb";}
	public function selfColId(){return "id";}
	public function selfColName(){return "word";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>