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

          </div>
        </div>
      </div>
    </section>
    <?php
     ?>
<?php
  $toLoadJS = Array(
     'jquery' => true,
     'logClass' => true,
     'userClass' => true,
     'alertClass' => true,
     'dbQueryClass' => true,
     'cardClass' => true,
     'generals' => true,
     'homePage' => true,
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
