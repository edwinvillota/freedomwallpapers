<?php
  sec_session_start();
  if(isset($_POST['id'])){
    // Definir el downloader
    if(isset($_SESSION['user'])){
      $user = unserialize($_SESSION['user']);
      $userid = $user->getId();
    } else {
      $userid = NULL;
    }
    // Crear el objeto wallpaper
    $wall = Wallpaper::getWallpaper($_POST['id']);
    if($wall->addDownload($userid) == true){
      echo json_encode(true);
    } else {
      echo json_encode(false);
    }
  }


 ?>
