<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

if (isset($_POST["question"])) {
    $gp = new GPFunctions();
    header($gp->jsonHeader());



    $search = new Search();
    $search->loadEntities();

    $input = trim($_POST["question"]);
    $is_random = 0;
    if ($input == 'random') {
        $input = $search->getRandomQuery();
        $is_random = 1;
    }

    function saveAndExit($arr) {

        global $gp;
        global $is_random;
        global $input;

        if (!isset($_SESSION["st"]["visitor"]["id"])) {
            $gp->jsonExit(["success" => false, "input" => $input, "msg" => "Ingen session startad", "results" => []]);
        }
        $v = new Visitor($_SESSION["st"]["visitor"]["id"]);
        STSearch::init($v, $input, count($arr["results"]), $is_random);
        $gp->jsonExit($arr);
    }

    /* List names */
    try {
        $entity = $search->getEntitySelfMatch($input);
        saveAndExit(["success" => true, "input" => $input, "msg" => "", "results" => [
                [
                    "type" => "entity_self_match",
                    "main" => '<a href="' . $entity->selfListUrl() . '">' . $entity->selfNamePlural() . '</a>',
                    "info" => "Lista",
                    "has_page" => true,
                ]
        ]]);
    } catch (Exception $e) {
        
    }

    /* Attribute values by name and attribute */
    $results = $search->getEntitiesByNameAndAttribute($input);
    if (count($results) > 0) {
        $arr = [];
        foreach ($results as $result) {
            $e = $result["entity"];
            $attr = $e->getAttributes()[$result["column"]];
            $arr[] = [
                "type" => "",
                "main" => $e->toValue($attr),
                "info" => '<a href="' . $e->selfListUrl() . '">' . $e->selfNamePlural() . '</a> / ' . $e->toLink() . ' / ' . $attr["singular"] . '',
                "has_page" => $e->hasPage()
            ];
        }
        saveAndExit(["success" => true, "input" => $input, "msg" => "", "results" => $arr]);
    }

    /* Entity names by value and attribute */
    $entities = $search->getEntitiesByValueAndAttribute($input);
    if (count($entities) > 0) {
        $arr = [];
        foreach ($entities as $e) {
            $arr[] = [
                "type" => "",
                "main" => $e->toLink(),
                "info" => '<a href="' . $e->selfListUrl() . '">' . $e->selfName() . '</a>',
                "has_page" => $e->hasPage()
            ];
        }
        saveAndExit(["success" => true, "input" => $input, "msg" => "", "results" => $arr]);
    }

    /* Entity names */
    $entities = $search->getEntitiesByName($input);
    if (count($entities) > 0) {
        $arr = [];
        foreach ($entities as $e) {
            $arr[] = [
                "type" => "entity_name_match",
                "main" => $e->toLink(),
                "info" => '<a href="' . $e->selfListUrl() . '">' . $e->selfName() . '</a>',
                "has_page" => $e->hasPage()
            ];
        }
        saveAndExit(["success" => true, "input" => $input, "msg" => "", "results" => $arr]);
    }
    saveAndExit(["success" => false, "input" => $input, "msg" => "Inget resultat hittades", "results" => []]);
}

require_once 'class.page.php';

$page = new Page();
$page->setTitle("Sök");

echo $page->serveTop();
?>
<div style="max-width:700px;">
    <p style="margin-top:0px;">
            <!--<input autofocus id="question" autocomplete="off"  class="w3-input w3-card w3-padding" placeholder="" type="text">-->
        <button id="random" class="w3-button w3-pale-green w3-small w3-padding-small w3-margin-top">Exempel</button>
    </p>
    <p>
        <span id="status"></span>
    </p>
    <p>
        <span id="results"></span>
    </p>
    <?php
    $last_value = "''";
    if (isset($_POST["z_question"])) {
        //$last_value = json_encode($_POST["z_question"]);
        $last_value = "''";
    }
    ?>
    <script>
        var Ask = {
            el: {
                question: document.getElementById('z_question'),
                status: document.getElementById('status'),
                results: document.getElementById('results')
            },
            is_sending: false,
            is_waiting: false,
            is_random: false,
            last_value: <?= $last_value ?>,
            nr_searches: 0,
            timeout: 0,
            onKeyUp: function () {

                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
                var self = this;
                this.timeout = setTimeout(function () {
                    self.search()
                }, 200);
            },
            setStatus: function (text) {
                this.el.status.innerHTML = text;
            },
            setResult: function (text) {
                this.el.results.innerHTML = text;
            },
            addResult: function (text) {
                this.el.results.innerHTML += text;
            },
            search: function () {
                var val = this.el.question.value;
                if (this.is_sending) {
                    this.is_waiting = true;
                    return;
                }
                if (val == this.last_value) {
                    return;
                }
                if (val == "") {
                    this.setResult("");
                    this.setStatus("");
                    return;
                }
                this.last_value = val;
                var FD = new FormData();
                FD.append('question', val);
                this.send(FD);
            },
            random: function () {
                this.is_random = true;
                var FD = new FormData();
                FD.append('question', 'random');
                FD.append('random', 'yes');
                this.send(FD);
            },
            send: function (FD) {
                this.nr_searches++;
                this.setResult("");
                this.setStatus("Laddar...");

                var XHR = new XMLHttpRequest();

                XHR.addEventListener('load', Ask.onSuccess);
                XHR.addEventListener('error', Ask.onFailure);
                XHR.open('POST', '/sok/');
                XHR.send(FD);
            },
            onSuccess: function (e) {
                if (e.currentTarget.status !== 200) {
                    return Ask.setStatus("Sidan hittades inte");
                }
                resp = JSON.parse(e.currentTarget.responseText);
                if (Ask.is_random) {
                    Ask.el.question.value = resp.input;
                    Ask.last_value = resp.input;
                }
                Ask.is_random = false;
                if (resp.success === false) {
                    return Ask.setStatus(resp.msg);
                }
                console.log('onSuccess', e);
                Ask.setStatus("");
                Ask.serveResults(resp.results);
            },
            onFailure: function (e) {
                Ask.setStatus("Kolla din internetanslutning");
            },
            serveResults: function (results) {
                if (results.length == 0) {
                    return this.setResult("");
                }
                var html = "<ul class='w3-ul w3-card-4'>";
                for (var i = 0; i < results.length; i++) {
                    html += this.resultToString(results[i]);
                }
                html += "</ul>";
                this.setResult(html);
            },
            resultToString: function (result) {
                var html = "<li class='w3-bar' style='padding: 0px 0px;'>";
                html += "<div class='w3-bar-item'><span class='w3-medium'>";
                html += result.main;
                html += "</span><br><span class='w3-small w3-text-gray'>" + result.info + "</span></div></li>";
                return html;
            },
            init: function () {
                document.getElementById("z_question").addEventListener("keyup", function (event) {
                    event.preventDefault();
                    Ask.onKeyUp();
                    return false;
                });
                document.getElementById("random").addEventListener("click", function (event) {
                    event.preventDefault();
                    Ask.random();
                    return false;
                });
                Ask.search();
                document.getElementById("z_question").addEventListener("focus", function (event) {
                    this.select();
                });
                document.getElementById("z_question").addEventListener("blur", function (event) {
                    //document.getElementById("z_question").style.fontSize = '12px';
                });
            }
        };
        Ask.init();
    </script>

</div>

<?php
echo $page->serveBottom();
?>