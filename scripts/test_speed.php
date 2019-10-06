<?php
$start = microtime(true);
define("PATH", "../../../");
require_once '../core/autoload.php';
require_once '../pages/class.page.php';
$seconds_loading = microtime(true) - $start;
$start2 = microtime(true);

$page = new Page();
$page->setTitle("test_speed.php");
?>

<?= $page->serveTop() ?>

<h1><?= $page->getTitle() ?></h1>

<ul>
    <li>Loading classes: <?= $seconds_loading ?> seconds</li>
    <li>Serving top-template: <?= (microtime(true) - $start2) ?> seconds</li>
    <?php
    $start3 = microtime(true);
    $sql = "SELECT * FROM z_exoplanets WHERE id=3000";
    $query = $DB->query($sql);
    ?>
    <li>Loading one exoplanet: <?= (microtime(true) - $start3) ?> seconds</li>
</ul>

<?= $page->serveBottom() ?>
