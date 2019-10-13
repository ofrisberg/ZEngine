<?php

abstract class ManageDB extends Entity {

    public function selfFile() {
        return "";
    }

    function __construct($attr_rows) {
        parent::__construct($attr_rows);
    }

    public function selfTotRows() {
        global $DB;
        return (int) $DB->query("SELECT count(*) as c FROM " . $this->selfTable() . "")->fetch_assoc()['c'];
    }

    public function selfTotColumns() {
        global $DB;
        return count($DB->query("SELECT * FROM " . $this->selfTable() . " LIMIT 1")->fetch_assoc());
    }

    public function loadById($id) {
        $row = $this->getRowByCol($this->selfColId(), $id);
        $this->loadAttributes($row);
    }

    public function loadByName($name) {
        $row = $this->getRowByCol($this->selfColName(), $name);
        $this->loadAttributes($row);
    }

    public function loadByCol($col, $val) {
        $row = $this->getRowByCol($col, $val);
        $this->loadAttributes($row);
    }

    public function loadRandom() {
        global $DB;
        $query = $DB->query("SELECT * FROM " . $this->selfTable() . " ORDER BY rand() LIMIT 1");
        $this->loadAttributes($query->fetch_assoc());
    }

    public function searchByName($name) {
        global $DB;
        $name = $DB->real_escape_string($name);
        $query = $DB->query("SELECT * FROM " . $this->selfTable() . " WHERE " . $this->selfColName() . " LIKE '$name%' ORDER BY LENGTH(" . $this->selfColName() . ") ASC LIMIT 1");
        if ($query->num_rows == 0) {
            throw new Exception("Couldnt find row");
        }
        $this->loadAttributes($query->fetch_assoc());
    }

    public function loadAll($offset, $limit, $order = null) {
        $entities = [];
        global $DB;
        if ($order == null) {
            $order = $this->selfColName();
        }
        $query = $DB->query("SELECT * FROM " . $this->selfTable() . " ORDER BY $order LIMIT $offset,$limit");
        if ($query->num_rows == 0) {
            return [];
        }
        $class = get_called_class();
        while ($row = $query->fetch_assoc()) {
            $e = new $class($this->attr_rows);
            $e->loadAttributes($row);
            $entities[] = $e;
        }
        return $entities;
    }

    protected function getRowByCol($col, $val) {
        global $DB;
        $val = $DB->real_escape_string($val);
        $query = $DB->query("SELECT * FROM " . $this->selfTable() . " WHERE $col='$val' LIMIT 1");
        if ($query->num_rows == 0) {
            throw new Exception("Couldnt find row");
        }
        return $query->fetch_assoc();
    }

    public function getSorting() {
        return new SortingDB($this);
    }

}

?>