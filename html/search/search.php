<?php
  include(HTML_DIR . 'overall/head.php');
  include(HTML_DIR . 'overall/navbar.php');
?>

<section class="searchBarSection">
  <div class="container">
    <div class="row">
      <form class="form mx-auto form-inline">
        <div class="from-group mb-1 col-12 col-sm-6 col-lg-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" id="searchBtn">Buscar</button>
            </span>
            <input type="text" class="form-control" placeholder="Buscar" id="keywordInput" value="<?php (isset($_GET['keyword'])) ? print($_GET['keyword']) : '';?>">
          </div>
        </div>
        <div class="form-group mb-1 col-12 col-sm-6 col-lg-3">
          <select class="custom-select col-12" id="categoryInput">
            <option value="0" selected>Categorias</option>
            <?php
              $c = new Collection();
              $categories = $c->getCategories();
              unset($c);
              if(isset($_GET['category'])){
                foreach ($categories as $key => $value) {
                  if($_GET['category'] == $value['id']){
                    echo '<option selected value="' . $value['id'] . '">' . $value['name'] . '</option>';
                  } else {
                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                  }
                }
              } else {
                foreach ($categories as $key => $value) {
                  echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
              }


             ?>
          </select>
        </div>
        <div class="form-group mb-1 col-12 col-sm-6 col-lg-3">
          <div class="input-group w-100">
            <span class="input-group-addon col-3" id="basic-addon1">Color</span>
            <input type="color" class="form-control col-7" aria-describedby="basic-addon1" id="colorInput" value="<?php (isset($_GET['color'])) ? print("#{$_GET['color']}") : print('#000000') ?>">
            <span class="input-group-addon col-2">
              <input type="checkbox" aria-label="Checkbox for following text input" id="byColorInput" <?php (isset($_GET['color'])) ? print('checked') : print('') ?>>
          </span>
          </div>
        </div>
        <div class="form-group col-12 col-sm-6 col-lg-3">
          <select class="custom-select col-12" id="sortInput">
            <?php (isset($_GET['sort'])) ? $sort = $_GET['sort'] : $sort = 0;?>
            <option value="0" <?php ($sort == 0) ? print(' selected') : print('');?>>Ordenar por</option>
            <option value="1" <?php ($sort == 1) ? print(' selected') : print('');?>>Recientes</option>
            <option value="2" <?php ($sort == 2) ? print(' selected') : print('');?>>Mas Descargados</option>
            <option value="3" <?php ($sort == 3) ? print(' selected') : print('');?>>Con Mejor Calificacion</option>
          </select>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="wallResultSection">
  <div class="container">
    <div class="row">
      <div class="card-columns">
        <?php
          foreach ($resultWalls as $key => $w) {
            echo $w;
          }
         ?>
      </div>
    </div>
  </div>
</section>

<section class="pageNavSection">
  <div class="container">
    <?php
      $nav = new Pagnav($numResults,12,$page);
      echo $nav->getHTML();
     ?>
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
    'cardClass' => true,
    'searchClass' => true,
    'generals' => true,
    'loginScript' => true,
    'registerScript' => false,
    'dropWallpaper' => false,
    'homePage' => false,
    'searchPage' => true,
    'libsTether' => false,
    'libsBootstrap' => true,
    'libsVibrant' => false,
    'libsFileInput' => false,
    );
  $toLoadCSS = Array(
    'hometemplate' => false,
    'registertemplate' => false,
    'addWallpapertemplate' => false,
    'searchtemplate' => true,
    'navbartemplate' => true,
    'fontawesome' => true
  );

  echo Autoload::loadCSS($toLoadCSS);
  echo Autoload::loadJS($toLoadJS);
 ?>
