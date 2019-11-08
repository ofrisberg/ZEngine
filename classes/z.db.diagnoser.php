<?php

class ZDiagnoser extends ManageDB implements iEntity{
	
    public function selfName(){return "Diagnos";}
    public function selfNamePlural(){return "Diagnoser";}
    public function selfUrl(){return "diagnos";}
    public function selfUrlPlural(){return "diagnoser";}

    public function selfTable(){return "z_diagnoser";}
    public function selfColId(){return "d_id";}
    public function selfColName(){return "d_name";}

    function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>