<?php 
sec_session_start();
if(isset($_SESSION['user'])){
	$u = unserialize($_SESSION['user']);
	$result = $u->logout();
	echo json_encode($result);	
} else {
	echo json_encode(false);
}

?>