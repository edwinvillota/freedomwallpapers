<?php
	$c = new Collection();

	$result = $c->getCategories();
	echo json_encode($result);

?>
