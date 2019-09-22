<?php
define("PATH", "../../../");
require_once PATH . 'php/setup.php';

require_once '../core/interface.entity.php';
require_once '../core/class.entity.php';
require_once '../core/class.manage.db.php';
require_once '../core/class.manage.txt.php';

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
        echo $entity->toListItem($attr) . '<br>';
    }
}
echo '</p>';
echo $page->serveBottom();

