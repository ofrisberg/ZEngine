<?php

define("PATH","../../../");
require_once PATH.'php/setup.php';

require_once '../core/interface.entity.php';
require_once '../core/class.entity.php';
require_once '../core/class.manage.db.php';
require_once '../core/class.manage.txt.php';

require_once 'class.page.php';

$entity_rows = Entity::getEntityRows();
foreach($entity_rows as $e_row){
	require_once '../classes/'.$e_row['e_filename'];
}

$page = new Page();
$page->setTitle("Listor");

echo $page->serveTop();
?>
<p>
	Listor
</p>
<h1>Listor</h1>
<p>Detta är en lista med listor.</p>
<table class="w3-table w3-bordered">
<?php
foreach($entity_rows as $e_row){
	$entity = new $e_row['e_class'](Entity::getAttrRows($e_row['e_class']));
	?>
	<tr>
		<td><a href="<?= $entity->selfListUrl() ?>"><?= $entity->selfNamePlural() ?></a></td>
		<td><?= $entity->selfTotRows() ?></td>
	</tr>
	<?php
}

?>
</table>
<?php
echo $page->serveBottom();
?>