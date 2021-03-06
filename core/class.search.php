<?php

class Search {

    private $entities;
    private $excludeClassNames = ["ZGatunamn"];

    function __construct() {
        $this->entities = [];
    }

    public function setExcludeClassNames($classNames) {
        $this->excludeClassNames = $classNames;
    }

    public function getEntitySelfMatch($str) {
        foreach ($this->entities as $e) {
            if (preg_match('/^(' . $e->selfName() . '|' . $e->selfNamePlural() . ')$/iu', $str, $matches)) {
                return $e;
            }
        }
        throw new Exception("no EntitySelfMatch found");
    }

    public function getEntitiesByName($str, $searchBool = true) {
        $arr = [];
        foreach ($this->entities as $e) {
            try {
                if ($searchBool) {
                    $e->searchByName($str);
                } else {
                    $e->loadByName($str);
                }
                $arr[] = $e;
            } catch (Exception $exception) {
                
            }
        }
        return $arr;
    }

    public function getEntitiesByValueAndAttribute($str) {
        $arr = [];
        foreach ($this->entities as $e) {
            $attrs = $e->selfAttributeRows();
            foreach ($attrs as $attr) {
                if (preg_match('/^' . $attr['a_singular'] . ' (.*)$/iu', $str, $matches)) {
                    try {
                        $e->loadByCol($attr['a_column'], $matches[1]);
                        $arr[] = $e;
                    } catch (Exception $exception) {
                        
                    }
                } else if (preg_match('/^(.*) ' . $attr['a_singular'] . '$/iu', $str, $matches)) {
                    try {
                        $e->loadByCol($attr['a_column'], $matches[1]);
                        $arr[] = $e;
                    } catch (Exception $exception) {
                        
                    }
                }
            }
        }
        return $arr;
    }

    public function getEntitiesByNameAndAttribute($str) {
        $arr = [];
        foreach ($this->entities as $e) {
            $attrs = $e->selfAttributeRows();
            foreach ($attrs as $attr) {
                if (preg_match('/^' . $attr['a_singular'] . ' (.*)$/iu', $str, $matches)) {
                    try {
                        $e->loadByName($matches[1]);
                        $arr[] = ["entity" => $e, "column" => $attr['a_column']];
                    } catch (Exception $exception) {
                        
                    }
                } else if (preg_match('/^(.*) ' . $attr['a_singular'] . '$/iu', $str, $matches)) {
                    try {
                        $e->loadByName($matches[1]);
                        $arr[] = ["entity" => $e, "column" => $attr['a_column']];
                    } catch (Exception $exception) {
                        
                    }
                }
            }
        }
        return $arr;
    }

    public function isAttribute($str) {
        foreach ($this->entities as $e) {
            $attrs = $e->selfAttributeRows();
            foreach ($attrs as $attr) {
                if (preg_match('/^' . $attr['a_singular'] . '$/iu', $str, $matches)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function loadEntities($pathToClassDir = '..', $pathToTxt = '../txt') {
        $entity_rows = Entity::getEntityRows();
        foreach ($entity_rows as $e_row) {
            if (!in_array($e_row['e_class'], $this->excludeClassNames)) {
                require_once $pathToClassDir . '/classes/' . $e_row['e_filename'];
                $e = new $e_row['e_class'](Entity::getAttrRows($e_row['e_class']));
                $e->setPathToTxtDir($pathToTxt);
                $this->entities[] = $e;
            }
        }
    }

    public function getRandomQuery() {
        $e = $this->getRandomEntity();
        $rand = rand(1, 100);
        if ($rand <= 10) {
            $out = $e->selfNamePlural(); //get random list name
        } else if ($rand > 10 && $rand <= 55) {
            //get random value
            $e->loadRandom();
            $out = $e->getName();
        } else {
            //get random value and attribute
            $e->loadRandom();
            $bool = true;
            while ($bool) {
                $shuffled_array = $this->getShuffledAttributes($e);
                foreach ($shuffled_array as $attr_tmp) {
                    if (in_array($attr_tmp['type'], ['number', 'decimal', 'short'])) {
                        $bool = false;
                        $attr = $attr_tmp;
                    }
                }
                if ($bool) {
                    $e = $this->getRandomEntity();
                    $e->loadRandom();
                }
            }
            $out = $e->getName() . " " . $attr['singular'];
        }
        return mb_strtolower($out, 'UTF-8');
    }

    public function getRandomValueAttributeQuestion() {
        $e = $this->getRandomEntity();
        $e->loadRandom();
        while (true) {
            $attributes = $this->getShuffledAttributes($e);
            foreach ($attributes as $testAttr) {
                $attrObj = new Attribute($e, $testAttr);
                $question = $attrObj->getQuestion();
                if ($question != "") {
                    return $question;
                }
            }
            $e = $this->getRandomEntity();
            $e->loadRandom();
        }
    }

    public function getRandomEntity() {
        return $this->entities[rand(0, count($this->entities) - 1)];
    }

    private function getShuffledAttributes($entity) {
        $attrs = $entity->getAttributes();
        $shuffled_array = array();
        $keys = array_keys($attrs);
        shuffle($keys);
        foreach ($keys as $key) {
            $shuffled_array[$key] = $attrs[$key];
        }
        return $shuffled_array;
    }

}

?>