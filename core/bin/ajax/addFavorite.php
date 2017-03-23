<?php
  sec_session_start();
  if(isset($_SESSION['user']) && isset($_POST['id'])){
    $user = unserialize($_SESSION['user']);
    $userid = $user->getId();
    $wallid = $_POST['id'];
    $wall = Wallpaper::getWallpaper($wallid);
    echo json_encode($wall->addFavorite($userid));
  } else {
    echo json_encode('No se ha iniciado session');
  }


 ?>
