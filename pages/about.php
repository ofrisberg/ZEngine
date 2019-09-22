<?php
define("PATH", "../../../");
require_once PATH . 'php/setup.php';

require_once '../core/interface.entity.php';
require_once '../core/class.entity.php';
require_once '../core/class.manage.db.php';
require_once '../core/class.manage.txt.php';

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

<h2>Sökhjälp</h2>
<p>Det finns fyra olika sätt att söka. Vid varje sökning kommer alla fyra sökningssätt ske men inte i ordningen nedan pga optimeringskäl.</p>
<ul class="w3-ul">
    <li class="w3-padding-small">
        <h4>1. Listnamn</h4>
        <p>Hela sökordet måste matcha. Kan vara plural eller singular. Returnerar listnamn.<br/>
            Exempel: <code class="w3-codespan">grundämne</code> ger <i>Grundämnen (lista)</i></p>
    </li>
    <li class="w3-padding-small">
        <h4>2. Objektnamn</h4>
        <p>Hela sökordet måste matcha. Returnerar objektnamn.<br/>
            Exempel: <code class="w3-codespan">helium</code> ger <i>Helium (grundämne)</i></p>
    </li>
    <li class="w3-padding-small">
        <h4>3. Objektnamn och attribut</h4>
        <p>Attributet måste vara först eller sist i sökordet. Returnerar värde.<br/>
            Exempel: <code class="w3-codespan">helium atomnummer</code> ger <i>2 (Heliums atomnummer)</i></p>
    </li>
    <li class="w3-padding-small">
        <h4>4. Värde och attribut</h4>
        <p>Attributet måste vara först eller sist i sökordet. Returnerar objektnamn.<br/>
            Exempel: <code class="w3-codespan">he beteckning</code> ger <i>Helium (grundämne)</i></p>
    </li>
</ul>
<p>Alla sökningar är skiftesokänsliga, 
    <code class="w3-codespan">hElIuM</code> = <code class="w3-codespan">helium</code> = <code class="w3-codespan">HELIUM</code>.</p>

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