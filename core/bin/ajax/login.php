<?php
	$ur = json_decode($_POST['user']);
	$u = new User($ur->name,$ur->email,$ur->password);
	if($u->login()){
		sec_session_start();
		$_SESSION['user'] = serialize($u);
		echo json_encode(true);
	} else {
		echo json_encode(false);
	}


?>
