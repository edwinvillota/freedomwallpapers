<?php
sec_session_start();
	if(isset($_POST['wall']) && isset($_SESSION['user'])){
		// Obtener el usuario que inicio sesion
		$user = unserialize($_SESSION['user']);

		// Obtener el objeto wall
		$wall = json_decode($_POST['wall']);
		// Obtener el objeto Image
		$img = json_decode($_POST['img']);
		// Obtener el nombre del wallpaper
		$name = $_POST['name'];
		// Obtener el identificador de la categoria
		$categoryId = $_POST['category'];
		// Obtener la fecha de hoy
		$date = date('y\-m\-d G:i');
		// Obtener los tags
		$tags = '#all,#example';


		// Adecuar la url base 64
		$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img->src));

		// Crear un nuevo objeto Wallpaper
		$newWall = new Wallpaper($user->getId(), $name, $categoryId, $tags, $date, $wall->pallete, $wall->fileInfo, $img->height, $img->width);

		// Si el wallpaper se agrego
		if($newWall->add()){
			$folder = 'wallpapers/' . $newWall->getCategoryName();
			if(!file_exists($folder)){
			 	mkdir($folder);
			 }
			 file_put_contents($newWall->getUrl(),$data);
			 echo 'Se crearon las miniaturas: ' . $newWall->createThumbs();
			 echo json_encode(true);
		} else {
			echo json_encode(false);
		}

	} else {
		echo json_encode(false);
	}
 ?>
