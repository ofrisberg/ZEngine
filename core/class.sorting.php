<?php

abstract class Sorting {

    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
    }

    /**
     * Returns less than 0 if isAbnormalLow and greater than 0 if isAbnormalHigh and 0 if not abnormal
     */
    public abstract function isAbnormal($attr);
}

class SortingDB extends Sorting {

    public function __construct($entity) {
        parent::__construct($entity);
    }

    public function isAbnormal($attr) {
        if (!in_array($attr["type"], ["number", "decimal"])) {
            return 0;
        }
        $tbl = $this->entity->selfTable();
        $val = $attr["value"];
        $col = $attr["column"];
        if($val == 0){
            return 0;
        }
        
        global $DB;
        $sql = $this->buildSql($tbl, $col, $val, "<");
        if ($DB->query($sql)->num_rows == 0) {
            return -1;
        } else if ($DB->query($this->buildSql($tbl, $col, $val, ">"))->num_rows == 0) {
            return 1;
        }
        return 0;
    }

    private function buildSql($tbl, $col, $val, $sign) {
        return "SELECT * FROM $tbl WHERE $col $sign $val AND $col<>'0' AND $col NOT LIKE '%-%' AND $col NOT LIKE '% %' AND $col<>'$val'";
    }

}

class SortingTXT extends Sorting {

    public function __construct($entity) {
        parent::__construct($entity);
    }

    public function isAbnormal($attr) {
        return 0;
    }

}
