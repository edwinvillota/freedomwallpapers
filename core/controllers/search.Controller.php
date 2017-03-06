<?php
sec_session_start();
  if(count($_GET) > 1){
    $resultWalls = 'Se recibio parametros';
  } else {
    $c = new Collection();
    $resultWalls = $c->toCard($c->getRecent());
  }
  include('html/search/search.php')
?>
