<?php

define("PATH", "../../../");
require_once '../core/autoload.php';

exit();

/**
 * ename --- Kommun
 * ename_p --- Kommuner
 * ename_pl --- kommuner
 * evalue --- Linköpings kommun
 * aname --- Befolkningsmängd
 * aurl --- befolkningsmangd
 * avalue --- 200000
 */
$arr = [
    [
        "class" => "ZArter",
        "aqs" => [
            ["latin", "Vad kallas {{evalue}} på latin?"]
        ]
    ],
    [
        "class" => "ZCountries",
        "aqs" => [
            ["yta", "Hur stor är {{evalue}}s yta?"],
            ["huvudstad", "Vad heter {{evalue}}s huvudstad?"],
            ["landskod", "Vad är {{evalue}}s landskod?"],
            ["landsnummer", "Vad är {{evalue}}s landsnummer?"],
            ["kontinent", "Vilken kontinent tillhör {{evalue}}?"],
            ["valuta", "Vilken valuta använder {{evalue}}?"],
            ["engelska", "Vad heter {{evalue}} på engelska?"],
            ["storsta-berg", "Vad heter {{evalue}}s högsta berg?"],
            ["befolkning", "Hur många personer bor i {{evalue}}?"],
            ["toppdoman", "Vad heter {{evalue}}s toppdomän?"],
        ],
    ],
    [
        "class" => "ZElements",
        "aqs" => [
            ["atomnummer", "Vilket atomnummer har {{evalue}}?"],
            ["kokpunkt", "Vilken kokpunkt har {{evalue}}?"],
            ["densitet", "Vilken densitet har {{evalue}}?"],
            ["elektronkonfiguration", "Vilken elektronkonfiguration har {{evalue}}?"],
            ["smaltpunkt", "Vilken smältpunkt har {{evalue}}?"],
            ["engelska", "Vad heter {{evalue}} på engelska?"],
            ["beteckning", "Vad har {{evalue}} för beteckning?"],
        ],
    ],
];

foreach ($arr as $subarr) {
    $class = $subarr["class"];
    foreach ($subarr["aqs"] as $aq) {
        $question = $DB->real_escape_string($aq[1]);
        $a_url = $aq[0];
        $sql = "UPDATE attributes SET a_question='$question' WHERE e_class='$class' AND a_url='$a_url'";
        $DB->query($sql);
        echo $sql . "<br/>";
    }
}
