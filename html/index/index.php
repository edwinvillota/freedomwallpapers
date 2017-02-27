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
    <section class="randomSection bg-inverse">
      <div class="container py-2">
        <div class="row">
          <?php
            $u = new User('a','a','a');
            var_dump($u->login());
          ?>
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
