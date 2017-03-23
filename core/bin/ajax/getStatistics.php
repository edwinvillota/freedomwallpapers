<?php
  if(isset($_POST['id'])){
    $wallid = $_POST['id'];
    $wall = Wallpaper::getWallpaper($wallid);
    echo json_encode($wall->getStatistics());
  } else {
    echo json_encode(false);
  }
 ?>
