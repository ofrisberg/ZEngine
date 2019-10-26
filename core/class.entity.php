<?php

abstract class Entity {

    private $attributes = [];
    private $attributeObjects = [];
    protected $attr_rows = [];
    protected $path_txt = "../txt";

    function __construct($attr_rows) {
        $this->attr_rows = $attr_rows;
    }

    public function setPathToTxtDir($path) {
        $this->path_txt = $path;
    }

    public function loadAttributes($data_row) {
        foreach ($this->attr_rows as $attr_row) {
            foreach ($data_row as $key => $value) {
                if ($attr_row['a_column'] == $key) {
                    try {
                        $v = $this->parseValue($attr_row, $value);
                        $this->addAttribute($attr_row, $v);
                    } catch (Exception $e) {
                        //echo $e->getMessage();
                    }
                }
            }
        }
    }

    public function parseValue($attr_row, $val) {
        $val = $this->cleanValue($val);
        if (in_array($val, ["", "0", "-"])) {
            throw new Exception("Value '$val' is empty/zero/-");
        }
        return $val;
    }

    public function cleanValue($val) {
        $val = trim($val, '"');
        return $val . "";
    }

    private function addAttribute($attr_row, $value) {
        $arr = [
            "singular" => $attr_row["a_singular"],
            "plural" => "",
            "value" => $value,
            "type" => $attr_row["a_type"],
            "append" => $attr_row["a_append"],
            "column" => $attr_row["a_column"],
            "url" => $attr_row["a_url"],
            "question" => $attr_row["a_question"],
        ];
        $this->attributes[$attr_row["a_column"]] = $arr;
        $this->attributeObjects[] = new Attribute($this, $arr);
    }

    public function selfSource() {
        return "";
    }

    public function selfNamePrefix() {
        return "en";
    }
    
    public function selfNamePlural() {
        return $this->selfName();
    }

    public function selfUrlPlural() {
        return $this->selfUrl();
    }

    public function selfListUrl() {
        return '/z/' . $this->selfUrlPlural() . '/';
    }

    public function selfListDescription() {
        return "";
    }

    public function selfAttributeRows() {
        return $this->attr_rows;
    }
    
    public function selfIsAbnormalSearchFast(){
        return true;
    }

    public function searchByName($name) {
        return $this->loadByName($name);
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getAttributeObjects() {
        return $this->attributeObjects;
    }

    public function getId() {
        return $this->getAttributes()[$this->selfColId()]["value"];
    }

    public function getName() {
        return $this->getAttributes()[$this->selfColName()]["value"];
    }

    public function toLink() {
        $str = $this->getName();
        if ($this->hasPage()) {
            $str = "<a href='/z/" . $this->selfUrlPlural() . "/" . $this->getId() . "/'>" . $this->getName() . "</a>";
        }
        return $str;
    }

    public function toListItem($attr) {
        $out = $attr['singular'] . ': ' . $this->toValue($attr);
        return $out;
    }

    public function toValue($attr) {
        $val = $attr["value"];
        if ($attr["type"] == "number") {
            $val = intval($val);
        } else if ($attr["type"] == "decimal") {
            $val = floatval($val);
        } else if ($attr["type"] == "datetime") {
            $val = substr($val, 0, 10);
        }
        if ($attr["append"] != "") {
            $val = strval($val). " " . $attr["append"];
        }
        return $val;
    }

    public function hasPage() {
        return (count($this->getAttributes()) > 2);
    }

    /* Static methods */

    public static function getAttrRows($classname) {
        global $DB;
        $query = $DB->query("SELECT * FROM attributes WHERE e_class='$classname' ORDER BY a_singular");
        if ($query->num_rows == 0) {
            throw new Exception("No attributes added to '$classname'");
        }
        $arr = [];
        while ($attr_row = $query->fetch_assoc()) {
            $arr[] = $attr_row;
        }
        return $arr;
    }

    public static function getEntityRows() {
        global $DB;
        $query = $DB->query("SELECT * FROM entities ORDER BY e_name");
        if ($query->num_rows == 0) {
            throw new Exception("No entities added");
        }
        $arr = [];
        while ($entity_row = $query->fetch_assoc()) {
            $arr[] = $entity_row;
        }
        return $arr;
    }

    public static function getEntityRow($e_url) {
        global $DB;
        $e_url = $DB->real_escape_string($e_url);
        $query = $DB->query("SELECT * FROM entities WHERE e_url='$e_url'");
        if ($query->num_rows == 0) {
            throw new Exception("No entities added");
        }
        return $query->fetch_assoc();
    }

    public static function entityExist($e_url) {
        global $DB;
        $e_url = $DB->real_escape_string($e_url);
        return ($DB->query("SELECT e_url FROM entities WHERE e_url='$e_url'")->num_rows == 1);
    }

    public abstract function getSorting();
}

?>