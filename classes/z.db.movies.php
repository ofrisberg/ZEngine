<?php

class ZMovies extends ManageDB implements iEntity{
	
    public function selfName(){return "Film";}
    public function selfNamePlural(){return "Filmer";}
    public function selfUrl(){return "film";}
    public function selfUrlPlural(){return "filmer";}

    public function selfTable(){return "z_movies";}
    public function selfColId(){return "m_id";}
    public function selfColName(){return "m_name";}

    function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>