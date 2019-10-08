<?php
define("PATH", "../../../");
require_once '../core/autoload.php';

require_once 'class.page.php';

$page = new Page();
$page->setTitle("Om webbplatsen");
?>

<?= $page->serveTop() ?>

<h1><?= $page->getTitle() ?></h1>

<h2>Datalagring</h2>
<p>Genom att använda webbplatsen godkänner du att 
<ul>
    <li>cookies från Google Adsense sparas i din webbläsare,</li>
    <li>dina sökningar sparas och publiceras,</li>
    <li>din IP-adress och statistik från ditt besök sparas.</li>
</ul>
</p>

<h2>Kontakt</h2>
<p>
    Om det är någon information på webbplatsen som du vill ändra eller ta bort så kontakta ollefrisberg[snabela]hotmail.com.
</p>

<h2>Framtidsförslag</h2>
<p>
    Fixa så att det går att söka via flera olika medium som t.ex. via SMS, email, Messenger.<br/>
    Fixa så att besökare kan lägga till objekt och attribut (men att det inte publiceras innan någon form av verifiering).<br/>
    Fixa så att det går att sortera listor efter kolumnvärden.
</p>
<?php

function mostRecentModifiedFileTime($dirName, $doRecursive = false) {
    $d = dir($dirName);
    $lastModified = 0;
    while ($entry = $d->read()) {
        if ($entry != "." && $entry != "..") {
            if (!is_dir($dirName . "/" . $entry)) {
                $currentModified = filemtime($dirName . "/" . $entry);
            } else if ($doRecursive && is_dir($dirName . "/" . $entry)) {
                $currentModified = mostRecentModifiedFileTime($dirName . "/" . $entry, true);
            }
            if ($currentModified > $lastModified) {
                $lastModified = $currentModified;
            }
        }
    }
    $d->close();
    return date('Y-m-d H:i', $lastModified);
}
?>
<h2>Uppdateringar</h2>
<table class="w3-table w3-bordered">
    <tr><td>Senaste sidan</td><td><?= mostRecentModifiedFileTime(PATH . "p/zengine/pages/") ?></td></tr>
    <tr><td>Senaste kärnfilen</td><td><?= mostRecentModifiedFileTime(PATH . "p/zengine/core/") ?></td></tr>
    <tr><td>Senaste objekt-klassen</td><td><?= mostRecentModifiedFileTime(PATH . "p/zengine/classes/") ?></td></tr>
</table>


<?= $page->serveBottom() ?>