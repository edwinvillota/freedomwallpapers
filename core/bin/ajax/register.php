<?php

	$ur = json_decode($_POST['user']);
	$u = new User($ur->name,$ur->email,$ur->password);

	$state = $u->validateData();

	echo json_encode($state);

?>
