<?php

class Attribute {

    protected $parent;
    protected $arr;
    protected $name;
    protected $value;
    protected $type;
    protected $append;
    protected $column;
    protected $url;
    protected $question;

    function __construct($parent, $arr) {
        $this->parent = $parent;
        $this->arr = $arr;
        $this->name = $arr["singular"];
        $this->value = $arr["value"];
        $this->type = $arr["type"];
        $this->append = $arr["append"];
        $this->column = $arr["column"];
        $this->url = $arr["url"];
        $this->question = $this->parseQuestion($arr["question"]);
    }

    private function parseQuestion($template) {
        if ($template == "" || $template == null) {
            return "";
        }
        $evalue = $this->parent->getName();
        $out = str_replace("{{evalue}}", $evalue, $template);
        return $out;
    }

    public function hasQuestion() {
        return $this->url != "" && $this->question != "";
    }

    public function toListItem() {
        $text = $this->parent->toListItem($this->arr);
        if ($this->hasQuestion()) {
            return $text . " <a href='" . $this->getFullUrl() . "'>(Länk)</a>";
        }
        return $text;
    }

    /* --- GETTERS --- */

    function getArr() {
        return $this->arr;
    }
        
    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function getType() {
        return $this->type;
    }

    function getAppend() {
        return $this->append;
    }

    function getColumn() {
        return $this->column;
    }

    function getUrl() {
        return $this->url;
    }

    function getFullUrl() {
        $s = $this->parent->selfListUrl();
        $s .= $this->parent->getId() . "/";
        $s .= $this->getUrl() . "/";
        return $s;
    }

    function getQuestion() {
        return $this->question;
    }

}
