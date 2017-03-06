<?php
  // Crear una nueva Coleccion
  $c = new Collection();
  $res = $c->getRecent(15);
  if($res){
    echo json_encode($res);
  } else {
    echo json_encode(false);
  }



 ?>
