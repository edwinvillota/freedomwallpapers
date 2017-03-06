<?php
// Cargar Head y Navbar solo cuando se haya iniciado sesion

if(!isset($_SESSION['user'])){
	header('location: ?view=index');
	exit();
} else {
	include(HTML_DIR . 'overall/head.php');
	include(HTML_DIR . 'overall/navbar.php');
}
?>

<section class="newWallSection bg-inverse text-success">
	<div class="container">
		<div class="row">
			<div class="droparea col-12 leaveCSS">
				<h1 class="h3">Arrastra aquí el Wallpaper</h1>
			</div>
		</div>
		<div class="row" id="pallete">

		</div>
		<div class="row pb-2">
			<input type="file" data-filename-placement="inside" class="btn-outline-success text-success mx-auto mt-2" id="wallInputBtn" title="Examinar">
		</div>
	</div>
</section>
<section class="wallInfoSection bg-inverse text-success">
	<div class="container">
			<form class="mr-2">
			  <div class="form-group row">
				 <label for="example-text-input" class="col-3 col-sm-2 col-lg-1 col-form-label">Nombre</label>
		         <input class="form-control col-9 col-sm-10 col-lg-11 w-100" type="text" value="" id="wallNameInput">

				</div>
				<div class="form-group row">
					<label for="custom-select" class="col-4 col-sm-2 col-lg-1 col-form-label">Categoria</label>
					<select class="custom-select col-8 col-sm-10 col-lg-11" id="selectCategory">
					<option value="0">Categorias</option>}

					</select>
				</div>
				<div class="form-group row">
					<button type="button" class="btn btn-success mx-auto" id="uploadBtn">Guardar</button>
				</div>
			</form>
	</div>
</section>



<?php
  $toLoadJS = Array(
     'jquery' => true,
     'logClass' => false,
     'userClass' => true,
     'alertClass' => true,
     'dropareaClass' => true,
     'dbQueryClass' => true,
     'generals' => false,
     'loginScript' => false,
     'registerScript' => false,
     'dropWallpaper' => true,
     'libsTether' => true,
     'libsBootstrap' => true,
     'libsDroparea' => false,
     'libsVibrant' => true,
     'libsFileInput' => true

      );

  $toLoadCSS = Array(
    'hometemplate' => false,
    'registertemplate' => false,
    'addWallpapertemplate' => true,
    'navbartemplate' => true,
    'fontawesome' => true
  );
  echo Autoload::loadCSS($toLoadCSS);
  echo Autoload::loadJS($toLoadJS);

  include(HTML_DIR . 'overall/footer.php')
?>
