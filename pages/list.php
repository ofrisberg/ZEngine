<?php

define("PATH","../../../");
require_once PATH.'php/setup.php';

require_once '../core/interface.entity.php';
require_once '../core/class.entity.php';
require_once '../core/class.manage.db.php';
require_once '../core/class.manage.txt.php';

require_once 'class.page.php';

if(!isset($_GET["e_url"])){exit("Fel GET-params");}
if(!Entity::entityExist($_GET["e_url"])){Page::onNotFound();}

$e_row = Entity::getEntityRow($_GET["e_url"]);
require_once '../classes/'.$e_row['e_filename'];
$entity = new $e_row['e_class'](Entity::getAttrRows($e_row['e_class']));


$pagenum = 1;
$offset = 0;
$items_per_page = 50;
$tot_rows = $entity->selfTotRows();
$mainUrl = $entity->selfListUrl();

if(isset($_GET["sida"])){
	$pagenum = intval($_GET["sida"]);
	if($pagenum == 1){
		header('Location: '.$mainUrl);
		exit($mainUrl);
	}
	if($pagenum != $_GET["sida"]){Page::onNotFound();}
	$offset = ($pagenum-1) * $items_per_page;
}

if($offset > $tot_rows || $offset < 0 || $pagenum <= 0){Page::onNotFound();}
$links = [];
for($i = $pagenum - 5; $i < $pagenum; $i++){
	if($i > 0){
		$links[] = "<a class='w3-button' href='$mainUrl"."&sida="."$i'>$i</a>";
	}
}
$links[] = "<a class='w3-button w3-pale-green' href='$mainUrl"."&sida="."$pagenum'>$pagenum</a>";
for($i = $pagenum + 1; $i < $pagenum + 5; $i++){
	if((($i-1) * $items_per_page) < $tot_rows){
		$links[] = "<a class='w3-button' href='$mainUrl"."&sida="."$i'>$i</a>";
	}
}
$pagelinks = '<div class="w3-bar">'.implode(' ',$links).'</div>';
if(count($links) == 1){$pagelinks = "";}

$entities = $entity->loadAll($offset,$items_per_page);

$page = new Page();
$page->setTitle("Lista över ".$entity->selfNamePlural());

echo $page->serveTop();

?>
<p>
	<a href="/z/">Listor</a> / <?= $entity->selfNamePlural() ?>
</p>
<h1><?= $entity->selfNamePlural() ?></h1>
<?php
echo $pagelinks;
?>
<p>
	<ul class="w3-ul">
	<?php
	foreach($entities as $e){ ?>
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