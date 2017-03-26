<?php
  sec_session_start();
  if(isset($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
    $userId = $user->getId();
    $wallId = $_POST['id'];
    // Consultar los estados
    $wall = Wallpaper::getWallpaper($wallId);
    echo json_encode($wall->getUserWallStates($userId));
  } else {
    echo json_encode(false);
  }

 ?>
