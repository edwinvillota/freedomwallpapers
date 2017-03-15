<?php
sec_session_start();
  if(count($_GET) > 1){
    // Obtener los parametros y definir la busqueda;
    $params = array();
    $mode = 0;
    if(isset($_GET['keyword'])){ $mode += 1; $params['keyword'] = $_GET['keyword'];};
    if(isset($_GET['category'])){ $mode += 3; $params['category'] = $_GET['category'];};
    if(isset($_GET['color'])){ $mode += 5; $params['color'] = $_GET['color'];};
    if(isset($_GET['sort'])){ $mode += 10; $params['sort'] = $_GET['sort'];};

    # Tipos de busqueda
    # 1: Solo palabra clave
    # 3: Solo Categoria
    # 5: Solo Color
    # 10: Solo orden

    # 4: Palabra Clave y categoria
    # 6: Palabra Clave y Color
    # 9: Palabra Clave, Categoria y Color
    # 11: Palabra Clave y Orden

    # 8: Categoria y Color
    # 13: Categoria y orden
    # 14: Categoria , orden y Keyword
    # 15: Color y orden
    # 18: Categoria, Color y orden
    # 19: Todos los parametros

    $c = new Collection();
    $resultWalls = $c->toCard($c->getSearch($mode,$params));

  } else {
    $c = new Collection();
    $resultWalls = $c->toCard($c->getRecent());
  }
  include('html/search/search.php')
?>
