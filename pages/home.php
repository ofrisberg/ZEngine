<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

require_once 'class.page.php';

$entity_rows = Entity::getEntityRows();
foreach ($entity_rows as $e_row) {
    require_once '../classes/' . $e_row['e_filename'];
}

$page = new Page();
$page->setTitle("ZDB");

echo $page->serveTop();

function buildBox($name, $number, $url) {
    $css_outer = "w3-col l2 m4 s6 w3-center w3-padding-small";
    $css_inner = "w3-card w3-padding-8 w3-hover-pale-green";

    $s = "<div class='$css_outer'>";
    $s .= "<a href='$url' class='boxlink'><div class='$css_inner'>";
    $s .= "<p>$name<br/>";
    $s .= "<span>$number st</span></p>";
    $s .= "</div></a></div>";
    return $s;
}
?>
<style>
    .boxlink{font-style: normal;text-decoration: none; font-size: 16px;line-height:18px;}
    .boxlink p{margin:10px auto;}
    .boxlink span{font-size: 12px;color:gray;}
    .w3-padding-8{padding-top:1px;padding-bottom:1px;}
    #z{display: inline-block;animation-name: spin;animation-duration: 500ms; animation-timing-function: ease-in-out; animation-iteration-count: 1; }
    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }
</style>
<h1 class="w3-jumbo w3-center"><span id="z">Z</span>DB</h1>
<h2 class="w3-center w3-text-gray" style="margin-top:-20px;margin-bottom:40px;font-size:22px;">Sveriges spretigaste databas</h2>
<div class="w3-row">
    <?php
    $i = 0;
    foreach ($entity_rows as $e_row) {
        $entity = new $e_row['e_class'](Entity::getAttrRows($e_row['e_class']));
        if ($i != 0 && $i % 6 == 0) {
            echo '</div><div class="w3-row">';
        }
        echo buildBox($entity->selfNamePlural(), $entity->selfTotRows(), $entity->selfListUrl());
        $i++;
    }
    ?>
</div>
<?php
echo $page->serveBottom();
?>