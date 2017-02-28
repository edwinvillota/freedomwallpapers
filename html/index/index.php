<?php
include(HTML_DIR . 'overall/head.php');
include(HTML_DIR . 'overall/navbar.php');
?>

  <body>
    <section class="homeSection">
      <div class="container">
        <div class="welcomeText">
          <h2 class="display-1">Freedom Wallpapers</h2>
          <h5>El mejor sitio para descargar wallpapers.</h5>
        </div>
      </div>
    </section>
    <section class="recentSection bg-inverse">
      <div class="container py-2">

        <div class="row">
          <h1 class="display-2 text-white">Recientes</h1>
          <div class="card-columns">
          <?php

            $db = new ConnectionDB();
            $walls = $db->getArray('SELECT * FROM wallpapers ORDER BY id DESC LIMIT 12');
            foreach ($walls as $key => $value) {
                echo  '<div class="card card-inverse mb-2" style="background-color: #333">';
                echo  '<img class="card-img-top img-fluid" src="' . $value['thumb_small'] . '" alt="Card image cap">';
                echo  '<div class="card-block">';
                echo  '<h4 class="card-title">' . $value['name'] . '</h4>';
                echo  '<p class="card-text">' .
                  '<span style="color:#' . $value['color_vibrant'] . '">Vibrant </span>' .
                  'Esta es la descripcion del wallpaper' .
                 '</p>';
                echo  '</div>';
                echo  '</div>';
            }

            $u = Wallpaper::getWallpaper(1);
            echo $u->getUploader();
           ?>
          </div>
        </div>
      </div>
    </section>
<?php
  $toLoadJS = Array(
     'jquery' => true,
     'logClass' => true,
     'userClass' => true,
     'alertClass' => true,
     'generals' => true,
     'loginScript' => true,
     'registerScript' => false,
     'libsTether' => true,
     'libsBootstrap' => true
      );

  $toLoadCSS = Array(
    'hometemplate' => true,
    'registertemplate' => false,
    'navbartemplate' => true
  );
  echo Autoload::loadCSS($toLoadCSS);
  echo Autoload::loadJS($toLoadJS);
?>

<?php include(HTML_DIR . 'overall/footer.php'); ?>
