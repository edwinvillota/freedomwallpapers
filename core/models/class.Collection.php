<?php

  /**
   * Clase Coleccion para obtener wallpapers
   */
  class Collection
  {

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

    public function toCard($walls) {
      $cards = array();
      foreach ($walls as $key => $wall) {
        $card = '<a href=?view=wallpaper&id=' . $wall->id . '"><div class="card card-inverse mb-2">' .
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
