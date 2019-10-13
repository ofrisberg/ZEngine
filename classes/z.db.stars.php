<?php

//HYG database

class ZStars extends ManageDB implements iEntity{
	
	public function selfName(){return "Stjärna";}
	public function selfNamePlural(){return "Stjärnor";}
	public function selfUrl(){return "stjarna";}
	public function selfUrlPlural(){return "stjarnor";}
	
	public function selfTable(){return "z_stars";}
	public function selfColId(){return "hr";}
	public function selfColName(){return "hr_name";}
	
        public function loadAll($offset, $limit, $order = null) {
            return parent::loadAll($offset, $limit, "hr");
        }
        
        public function getName() {
            $othername = $this->getAttributes()["proper"]["value"];
            if($othername != null && $othername != ""){
                return parent::getName()." (".$othername.")";
            }
            return parent::getName();
        }

	function __construct($attr_rows) { parent::__construct($attr_rows); }

}