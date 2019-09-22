<?php

class ZPalindrom extends ManageTXT implements iEntity{
	
	public function selfName(){return "Palindrom";}
	public function selfUrl(){return "palindrom";}
	public function selfFile(){return "palindrom.txt";}
	
	function __construct($attr_rows) { parent::__construct($attr_rows); }

}





?>