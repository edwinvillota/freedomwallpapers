<?php
  sec_session_start();

  if(isset($_GET['id'])){
    $sWall = Wallpaper::getWallpaper($_GET['id']);
    if($sWall->name == NULL) {
      $sWall = 'Oops! No encontramos lo que estaba buscando...';
    };
      include('html/wallpaper/wallpaper.php');
  } else {
    header('location: index.php');
  }
?>
