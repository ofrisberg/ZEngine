<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

require_once 'class.page.php';

$page = new Page();
$page->setTitle("404 - Sidan hittades inte");
?>
<?= $page->serveTop() ?>
<h1><?= $page->getTitle() ?></h1>
<p class="w3-large">
    Sidan du försökte nå hittades inte.
</p>
<?= $page->serveBottom() ?>