<?php
define("PATH", "../../../");
require_once PATH . 'php/setup.php';

require_once '../core/interface.entity.php';
require_once '../core/class.entity.php';
require_once '../core/class.manage.db.php';
require_once '../core/class.manage.txt.php';

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