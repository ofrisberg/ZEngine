<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

require_once 'class.page.php';

if (!isset($_GET["e_url"])) {
    exit("Fel GET-params");
}
if (!Entity::entityExist($_GET["e_url"])) {
    Page::onNotFound();
}

$e_row = Entity::getEntityRow($_GET["e_url"]);
require_once '../classes/' . $e_row['e_filename'];
$attr_rows = Entity::getAttrRows($e_row['e_class']);
$entity = new $e_row['e_class']($attr_rows);


$pagenum = 1;

$nr_pages_before = 4;
$nr_pages_after = 4;

$offset = 0;
$items_per_page = 50;

$tot_rows = $entity->selfTotRows();
$tot_pages = ceil($tot_rows / $items_per_page);

$mainUrl = $entity->selfListUrl();

if (isset($_GET["sida"])) {
    $pagenum = intval($_GET["sida"]);
    if ($pagenum == 1) {
        header('Location: ' . $mainUrl);
        exit($mainUrl);
    }
    if ($pagenum != $_GET["sida"]) {
        Page::onNotFound();
    }
    $offset = ($pagenum - 1) * $items_per_page;
}

if ($offset > $tot_rows || $offset < 0 || $pagenum <= 0) {
    Page::onNotFound();
}
$links = [];

//first page
if (1 < $pagenum - $nr_pages_before) {
    $links[] = "<a class='w3-button' href='$mainUrl'>1</a>";
}

//pages before
for ($i = $pagenum - $nr_pages_before; $i < $pagenum; $i++) {
    if ($i > 0) {
        $links[] = "<a class='w3-button' href='$mainUrl" . "&sida=" . "$i'>$i</a>";
    }
}

//curent page
$links[] = "<a class='w3-button w3-pale-green' href='$mainUrl" . "&sida=" . "$pagenum'>$pagenum</a>";

//pages after
for ($i = $pagenum + 1; $i <= $pagenum + $nr_pages_after; $i++) {
    if ((($i - 1) * $items_per_page) < $tot_rows) {
        $links[] = "<a class='w3-button' href='$mainUrl" . "&sida=" . "$i'>$i</a>";
    }
}

//last page
if ($pagenum + $nr_pages_after < $tot_pages) {
    $links[] = "<a class='w3-button' href='$mainUrl" . "&sida=" . "$tot_pages'>$tot_pages</a>";
}

$pagelinks = '<div class="w3-bar">' . implode(' ', $links) . '</div>';
if (count($links) == 1) {
    $pagelinks = "";
}

$entities = $entity->loadAll($offset, $items_per_page);

$page = new Page();
$page->setTitle("Lista över " . $entity->selfNamePlural());

echo $page->serveTop();
?>
<p>
    <a href="/z/">Listor</a> / <?= $entity->selfNamePlural() ?>
</p>
<h1><?= $entity->selfNamePlural() ?></h1>
<?php
if ($pagenum == 1) {

    $listDescription = $entity->selfListDescription();
    if ($listDescription != "") {
        echo "<p>$listDescription</p>";
    }

    $attrElements = [];
    foreach ($attr_rows as $attr) {
        if (in_array($attr['a_type'], ['number', 'decimal', 'short', 'datetime'])) {
            $attrElements[] = "<code class='w3-codespan w3-small'>$attr[a_singular]</code>";
        }
    }
    if (count($attrElements) > 1) {
        echo "<p>Dessa egenskaper är sökbara men finns inte för varje " . lcfirst($entity->selfName()) . ": " . implode(" ", $attrElements) . "</p>";
    }
}


echo $pagelinks;
?>
<p>
<ul class="w3-ul">
    <?php foreach ($entities as $e) { ?>
        <li><?= $e->toLink() ?></li>
        <?php
    }
    ?>
</ul>
</p>
<?php
echo $pagelinks;
echo $page->serveBottom();
?>