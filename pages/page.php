<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

require_once 'class.page.php';

if (!isset($_GET["e_url"], $_GET["id"])) {
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

$page = new Page();
$page->setTitle($entity->getName());

echo $page->serveTop();
?>
<p>
    <a href="/z/">Listor</a> / <a href="<?= $entity->selfListUrl() ?>"><?= $entity->selfNamePlural() ?></a> / <?= $entity->getName() ?>
</p>
<?php
echo "<h1>" . $entity->getName() . "</h1>";
$attrs = $entity->getAttributes();

/* Print longs */
foreach ($attrs as $attr) {
    if ($attr['type'] == 'long') {
        echo $attr['value'];
    }
}

/* Print list */
echo '<p>';
foreach ($attrs as $attr) {
    if (in_array($attr['type'], ['number', 'decimal', 'short', 'datetime'])) {
        $attrObj = new Attribute($entity, $attr);
        echo $attrObj->toListItem() . "<br/>";
    }
}
echo '</p>';

$sorting = $entity->getSorting();
$abnormals = [];
foreach ($attrs as $attr) {
    $abnormal = $sorting->isAbnormal($attr);
    if ($abnormal < 0) {
        $abnormals[] = $attr["singular"] . " är lägst av alla " . $entity->selfNamePlural();
    } else if ($abnormal > 0) {
        $abnormals[] = $attr["singular"] . " är högst av alla " . $entity->selfNamePlural();
    }
}
if (count($abnormals) > 0) {
    echo '<p><b>Avvikande statistik: </b><br/>';
    foreach ($abnormals as $value) {
        echo $value . "<br/>";
    }
    echo '</p>';
}


echo $page->serveBottom();

