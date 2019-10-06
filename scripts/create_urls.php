<?php

define("PATH", "../../../");
require_once '../core/autoload.php';

exit();

function toAscii($str, $delimiter = '-') {
    $str = str_replace(['å', 'ä', 'ö', 'Å', 'Ä', 'Ö'], ['a', 'a', 'o', 'a', 'a', 'o'], $str);
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    return $clean;
}

$sql = "SELECT * FROM attributes";
$query = $DB->query($sql);
while ($row = mysqli_fetch_assoc($query)) {
    $url = toAscii($row["a_singular"]);
    $e_class = $row["e_class"];
    $a_column = $row["a_column"];
    $sql2 = "UPDATE attributes SET a_url='$url' WHERE e_class='$e_class' AND a_column='$a_column' LIMIT 1";
    $DB->query($sql2);
    echo $row["a_singular"] . ": $url<br>";
}