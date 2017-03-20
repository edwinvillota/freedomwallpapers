<?php

  /**
   * Clase Coleccion para obtener wallpapers
   */
  class Collection
  {
    private $pageItems = 12;

    function __construct()
    {
    }

    public function getRecent($n = 12){
      $db = new ConnectionDB();
      $stmt = $db->prepare('SELECT id FROM wallpapers ORDER BY id DESC LIMIT ?');
      $stmt->bind_param('i',$n);
      if($stmt->execute()){
        $stmt->bind_result($id);
        $walls = array();
        while($stmt->fetch()){
          $walls[] = Wallpaper::getWallpaper($id);
        }
        $stmt->close();
        $db->close();
        return $walls;
      } else {
        $stmt->close();
        $db->close();
        return false;
      }
    }

    public function getCategories(){
      $db = new ConnectionDB();
      $stmt = $db->prepare('SELECT c.id,c.name,COUNT(w.id) as total
      FROM categories AS c LEFT OUTER JOIN wallpapers AS w
      ON c.id = w.category_id GROUP BY `c`.id ORDER BY c.name');
      $categories = array();
      if($stmt->execute()){
        $stmt->bind_result($cid,$cname,$total);
        while($stmt->fetch()){
          $categories[] = array(
            'id' => $cid,
            'name' => $cname,
            'total' => $total
          );
        }
        $db->close();
        $stmt->close();
        return $categories;
      }
    }

    public function getSearch($mode = 0,$params = false, $page = 1, $limit = false){
        // Obtener el Limite
        $lO = ($page - 1) * $this->pageItems;
        $lI = "{$lO},{$this->pageItems}";
        ($limit) ? $lI = "LIMIT {$lI}" : $lI = '';

        $walls = array();
        $db = new ConnectionDB();
        // Convertir el color a decimal y dividirlo en r,g y b
        if(isset($params['color'])){
          // Obtener el color
          $color = $params['color'];
          // Obtener los rgb
          $r = substr($color,0,2);
          $g = substr($color,2,2);
          $b = substr($color,4,2);
          // Convertir a decimal
          $r = hexdec($r);
          $g = hexdec($g);
          $b = hexdec($b);
        }
        // Obtener el parametro por el cual ordenar
        if(isset($params['sort'])){
          switch ($params['sort']) {
            case 1: # Mas recientes
              $sort = 'id';
              break;
            default:
              $sort = 'id';
              break;
          }
        }

        switch ($mode) {
          case 1: # Solo palabra clave
            // Crear la consulta
            $sql = "SELECT id FROM wallpapers WHERE name LIKE ? {$lI}";
            $k = "%{$params['keyword']}%";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('s',$k);
            break;
          case 3: # Solo categoria
            // Crear la consulta
            $sql = "SELECT id FROM wallpapers WHERE category_id = ? {$lI}";
            $c = $params['category'];
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i',$c);
            break;
          case 5: # Solo Color
            // Crear la consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers) AS t WHERE D < 70 {$lI}";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('iii',$r,$g,$b);
            break;
          case 10: # Solo orden
            // Crear consulta
            $sql = "SELECT id FROM wallpapers ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            break;
          case 4: # Palabra clave y Categoria
            // Crear consulta
            $sql = "SELECT id FROM wallpapers WHERE name LIKE ? AND category_id = ? {$lI}";
            $k = "%{$params['keyword']}%"; $c = $params['category'];
            $stmt = $db->prepare($sql);
            $stmt->bind_param('si',$k,$c);
            break;
          case 6: # Palabra clave y Color
            // Crear la consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers WHERE name LIKE ?) AS t WHERE D < 70";
            $stmt = $db->prepare($sql);
            $k = "%{$params['keyword']}%";
            $stmt->bind_param('iiis',$r,$g,$b,$k);
            break;
          case 9: # Palabra clave, Categoria y Color
            // Crear la consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers WHERE name LIKE ? AND category_id = ?) AS t WHERE D < 70 {$lI}";
            $stmt = $db->prepare($sql);
            $k = "%{$params['keyword']}%"; $c = $params['category'];
            $stmt->bind_param('iiisi',$r,$g,$b,$k,$c);
            break;
          case 11: # Palabra clave y Orden
            $sql = "SELECT id FROM wallpapers WHERE name LIKE ? ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            $k = "%{$params['keyword']}%";
            $stmt->bind_param('s',$k);
            break;
          case 8: # Categoria y color
            // Crear Consulta
            // Crear la consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers WHERE category_id = ?) AS t WHERE D < 70 {$lI}";
            $stmt = $db->prepare($sql);
            $c = $params['category'];
            $stmt->bind_param('iiis',$r,$g,$b,$c);
            break;
          case 13: # Categoria y orden
            switch ($params['sort']) {
              case 1: # Mas recientes
                $sort = 'id';
                break;
              default:
                $sort = 'id';
                break;
            }
            $sql = "SELECT id FROM wallpapers WHERE category_id = ? ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            $c = $params['category'];
            $stmt->bind_param('i',$c);
            break;
          case 14: # Categoria orden y palabra clave
            $sql = "SELECT id FROM wallpapers WHERE name LIKE ? AND category_id = ? ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            $k = "%{$params['keyword']}%";
            $c = $params['category'];
            $stmt->bind_param('si',$k,$c);
            break;
          case 15: # Color y orden
            // Crear Consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers) AS t WHERE D < 70 ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('iii',$r,$g,$b);
            break;
          case 18: # Categoria, Color y Orden
            // Crear la Consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,category_id,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers WHERE category_id = ?) AS t WHERE D < 70 ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            $c = $params['category'];
            $stmt->bind_param('iiii',$r,$g,$b,$c);
            break;
          case 19: # Todos los parametros
            // Crear la consulta
            $sql = "SELECT id
            FROM
              (SELECT id,name,color_vibrant,
                SQRT(POW((? - CONV(LEFT(color_vibrant,2),16,10)),2) +
                POW((? - CONV(RIGHT(LEFT(color_vibrant,4),2),16,10)),2) +
                POW((? - CONV(RIGHT(color_vibrant,2),16,10)),2))
                AS D FROM wallpapers WHERE name LIKE ? AND category_id = ?) AS t WHERE D < 70 ORDER BY {$sort} DESC {$lI}";
            $stmt = $db->prepare($sql);
            $k = "%{$params['keyword']}%"; $c = $params['category'];
            $stmt->bind_param('iiisi',$r,$g,$b,$k,$c);
            break;
          default:
            $c = new Collection();
            return $c->getRecent();
            break;
        }

        if($stmt->execute()){
          $stmt->bind_result($id);
          $stmt->store_result();
          if($limit){
            while(($stmt->fetch()) && (count($walls) < $this->pageItems)){
              $walls[] = Wallpaper::getWallpaper($id);
            }
            $walls['results'] = $stmt->num_rows;
            return $walls;
          } else {
            $walls['results'] = $stmt->num_rows;
            return $walls;
          }
        }
        return false;
      }

    public function toCard($walls) {
      $cards = array();
      if(isset($walls['results'])){
        $cards['results'] = $walls['results'];
        unset($walls['results']);
      }
      foreach ($walls as $key => $wall) {
        $card = '<a href=?view=wallpaper&id=' . $wall->id . '><div class="card card-inverse mb-2">' .
                '<img class="card-img-top img-fluid" src="' . $wall->thumbs->small . '" alt="' . $wall->name . '">' .
                '<div class="card-block">' .
                '<h4 class="card-title">' . $wall->name . '</h4>' .
                '<p class="card-text">' .
                '<span style="color:#' . $wall->pallete->Vibrant . '">Categoria: </span>' . $wall->category_name . '</br>' .
                '<span style="color:#' . $wall->pallete->Vibrant . '">Dimensiones: </span>' . $wall->width . 'x' . $wall->height .
                '</p>' .
                '</div>' .
                '</div></a>';
        $cards[] = $card;
      }
      return $cards;
    }
  }


 ?>
