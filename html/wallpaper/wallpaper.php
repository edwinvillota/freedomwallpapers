<?php
  include(HTML_DIR . 'overall/head.php');
  include(HTML_DIR . 'overall/navbar.php');
?>

<section class="bigWallSection">
  <div class="container">
    <div class="bigWall row">
      <div class="bigImg col-12 col-sm-11">
        <?php
          echo '<img class="img-fluid mx-auto" id="rsWall" src="' . $sWall->url . '">';
         ?>

      </div>
      <div class="actionsBar col-12 col-sm-1 ">
        <div class="btn-group d-block" role="group" aria-label="Button group with nested dropdown">
          <a class="btn btn-primary col-2 col-sm-12" data-toggle="tooltip" data-placement="left" title="Descargar" download id="downloadBtn">
            <i class="fa fa-download" aria-hidden="true"></i>
          </a>
          <button type="button" class="btn btn-danger col-2 col-sm-12" data-toggle="tooltip" data-placement="left" title="Favoritos" id="addFavBtn">
            <i class="fa fa-heart" aria-hidden="true"></i>
          </button>
          <button type="button" class="btn btn-success col-2 col-sm-12 voteBtn" data-toggle="tooltip" data-placement="left" title="Me gusta" data-vote="1">
            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
          </button>
          <button type="button" class="btn btn-warning col-2 col-sm-12 voteBtn" data-toggle="tooltip" data-placement="left" title="No me gusta" data-vote="0">
            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
          </button>
          <button type="button" class="btn btn-secondary col-2 col-sm-12" data-toggle="tooltip" data-placement="left" title="Recortar">
            <i class="fa fa-crop" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="wallStatisticsSection">
  <div class="container">
    <span class="text-muted">Descargas <span class="badge badge-primary" id="downloadsCount">0</span></span>
    <span class="text-muted">Favoritos <span class="badge badge-danger" id="favoritesCount">0</span></span>
    <span class="text-muted">Me gusta <span class="badge badge-success" id="likesCount">0</span></span>
    <span class="text-muted">No me gusta <span class="badge badge-warning" id="dislikesCount">0</span></span>
  </div>
</section>

<?php
  $toLoadJS = Array(
    'jquery' => true,
    'logClass' => true,
    'userClass' => true,
    'alertClass' => true,
    'dropareaClass' => false,
    'dbQueryClass' => true,
    'cardClass' => false,
    'searchClass' => false,
    'generals' => true,
    'loginScript' => true,
    'registerScript' => false,
    'dropWallpaper' => false,
    'homePage' => false,
    'searchPage' => false,
    'wallpaperPage' => true,
    'libsTether' => true,
    'libsBootstrap' => true,
    'libsVibrant' => false,
    'libsFileInput' => false,
    );
  $toLoadCSS = Array(
    'hometemplate' => false,
    'registertemplate' => false,
    'addWallpapertemplate' => false,
    'searchtemplate' => false,
    'wallpapertemplate' => true,
    'navbartemplate' => true,
    'fontawesome' => true
  );

  echo Autoload::loadCSS($toLoadCSS);
  echo Autoload::loadJS($toLoadJS);
 ?>
