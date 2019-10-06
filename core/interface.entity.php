<?php

interface iEntity {

    public function selfName();

    public function selfNamePlural();

    public function selfUrl();

    public function selfUrlPlural();

    public function selfColId();

    public function selfColName();

    public function selfSource();

    public function selfTotColumns();

    public function selfTotRows();

    public function selfListUrl();

    public function selfListDescription();

    public function selfAttributeRows();

    public function selfFile();

    public function selfTable();

    public function searchByName($name);

    public function loadById($id);

    public function loadByName($name);

    public function loadByCol($col, $val);

    public function loadRandom();

    public function loadAll($offset, $limit);

    public function loadAttributes($row);

    public function getId();

    public function getName();

    public function getAttributes();
    
    public function getAttributeObjects();
    
    public function getSorting();

    public function toLink();

    public function toListItem($attr);

    public function toValue($attr);

    public function hasPage();

    public function parseValue($attr_row, $val);
}

?>