<?php
	$db = new ConnectionDB();
	$result = $db->getArray('SELECT * FROM categories ORDER BY name');
	echo json_encode($result);

?>
