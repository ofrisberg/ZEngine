<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

require_once 'class.page.php';

if (!isset($_GET["e_url"], $_GET["id"], $_GET["a_url"])) {
    Page::onNotFound();
}
if (!Entity::entityExist($_GET["e_url"])) {
    Page::onNotFound();
}

$e_row = Entity::getEntityRow($_GET["e_url"]);
require_once '../classes/' . $e_row['e_filename'];
$entity = new $e_row['e_class'](Entity::getAttrRows($e_row['e_class']));

try {
    $entity->loadById($_GET["id"]);
} catch (Exception $e) {
    Page::onNotFound();
}

if (!$entity->hasPage()) {
    Page::onNotFound();
}

$attrObjects = $entity->getAttributeObjects();
$thisObj = null;
foreach ($attrObjects as $obj) {
    if ($_GET["a_url"] == $obj->getUrl()) {
        $thisObj = new Attribute($entity, $obj->getArr());
    }
}
if ($thisObj == null || !$thisObj->hasQuestion()) {
    Page::onNotFound();
}

$page = new Page();
$page->setTitle($thisObj->getQuestion());

echo $page->serveTop();
?>
<div style="text-align:center;padding:50px 0px;" itemscope itemtype="http://schema.org/Question">
    <span class="w3-large">Fråga:</span>
    <h1 style="margin-top:0px;" itemprop="name"><?= $thisObj->getQuestion() ?></h1>
    <span class="w3-large">Svar:</span>
    <h1 style="margin-top:0px;margin-bottom:30px;" 
        itemprop="suggestedAnswer acceptedAnswer" itemscope itemtype="http://schema.org/Answer">
        <span itemprop="text"><?= $thisObj->getValue() . " " . $thisObj->getAppend() ?></span>
    </h1>
    <span class="w3-medium w3-text-gray">
        <a href="/z/">Listor</a> / <a href="<?= $entity->selfListUrl() ?>"><?= $entity->selfNamePlural() ?></a> / <?= $entity->toLink() ?> / <?= $thisObj->getName() ?>
    </span>
</div>

<!--<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-col s12 m6 l4">
        <div class=" w3-card w3-container w3-margin-top">
            <h4>Om svaret</h4>
            
        </div>
    </div>
    <div class="w3-col s12 m6 l4">
        <div class=" w3-card w3-container w3-margin-top">
            <h4>Relaterade frågor</h4>

        </div>
    </div>
    <div class="w3-col s12 m6 l4">
        <div class=" w3-card w3-container w3-margin-top">
            <h4>Övrigt</h4>
            
        </div>
    </div>
</div>-->

<?= $page->serveBottom() ?>
