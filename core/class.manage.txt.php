<?php

abstract class ManageTXT extends Entity {

    public function selfTable() {
        return "";
    }

    public function selfColName() {
        return "0";
    }

    public function selfColId() {
        return "0";
    }

    public function selfTotColumns() {
        return 1;
    }

    public function selfTotRows() {
        $file = $this->path_txt . "/" . $this->selfFile();
        $linecount = 0;
        $handle = fopen($file, "r");
        while (!feof($handle)) {
            $line = fgets($handle);
            $linecount++;
        }
        fclose($handle);
        return $linecount;
    }

    public function loadById($id) {
        if ($this->selfTotColumns() == 1) {
            return $this->loadWhenSingleCol($id);
        }
        $this->loadByCol($this->selfColId(), $id);
    }

    public function loadByName($name) {
        if ($this->selfTotColumns() == 1) {
            return $this->loadWhenSingleCol($name);
        }
        $this->loadByCol($this->selfColName(), $name);
    }

    public function loadByCol($col, $val) {
        $f = fopen($this->path_txt . "/" . $this->selfFile(), 'r');
        while (!feof($f)) {
            $line = $this->trimLine(fgets($f));
            $arr = $this->splitLine($line);
            if (is_array($arr) && count($arr) == $this->selfTotColumns()) {
                $valQuote = preg_quote($val, '/');
                if (preg_match('/^' . $valQuote . '$/iu', $this->cleanValue($arr[$col]))) {
                    $this->loadAttributes($arr);
                    fclose($f);
                    return;
                }
            }
        }
        fclose($f);
        throw new Exception("Couldnt find row");
    }

    public function loadRandom() {
        $offset = rand(1, $this->selfTotRows() - 5);
        $iOffset = 1;
        $f = fopen($this->path_txt . "/" . $this->selfFile(), 'r');
        while (!feof($f)) {
            $line = $this->trimLine(fgets($f));
            if ($iOffset > $offset) {
                try {
                    $this->loadLine($line);
                    break;
                } catch (Exception $e) {
                    
                }
            }
            $iOffset++;
        }
        fclose($f);
    }

    public function loadAll($offset, $limit, $order = null) {
        $iOffset = 1;
        $iLimit = 1;
        $f = fopen($this->path_txt . "/" . $this->selfFile(), 'r');
        $entities = [];
        $class = get_called_class();
        while (!feof($f)) {
            $line = $this->trimLine(fgets($f));
            if ($iOffset > $offset) {
                $e = new $class($this->attr_rows);
                try {
                    $e->loadLine($line);
                    $entities[] = $e;
                    if (++$iLimit == $limit) {
                        break;
                    }
                } catch (Exception $e) {
                    
                }
            }
            $iOffset++;
        }
        fclose($f);
        return $entities;
    }

    public function loadLine($line) {
        if ($this->selfTotColumns() == 1) {
            $this->loadAttributes([$this->selfColName() => $line]);
        } else {
            $arr = $this->splitLine($line);
            if (is_array($arr) && count($arr) == $this->selfTotColumns()) {
                $this->loadAttributes($arr);
            } else {
                throw new Exception("Wrong number of columns");
            }
        }
    }

    public function loadWhenSingleCol($val) {
        $f = fopen($this->path_txt . "/" . $this->selfFile(), 'r');
        $found = false;
        while (!feof($f)) {
            $line = $this->trimLine(fgets($f));
            $valQuote = preg_quote($val, '/');
            if (preg_match('/^' . $valQuote . '$/iu', $line)) {
                $found = true;
                $this->loadAttributes([$this->selfColName() => $line]);
                break;
            }
        }
        fclose($f);
        if (!$found) {
            throw new Exception("Couldnt find row");
        }
    }

    public function trimLine($line) {
        return trim($line, "\r\n");
    }

    public function splitLine($line) {
        $arr = explode(',', $line);
        foreach ($arr as &$v) {
            $v = trim($v);
        }
        return $arr;
    }

    public function getSorting() {
        return new SortingTXT($this);
    }

}

?>