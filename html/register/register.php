<?php 

	include(HTML_DIR . 'overall/head.php');
	include(HTML_DIR . 'overall/navbar.php');

?>

	<section class="registerForm">
		<div class="container">
			<h1 class="display-4">Registrate</h1>
			<h4> Ingresa los siguientes datos.</h1>

			<form class="mt-4" id="regForm">
				  <div class="form-group emailSection">
				    <label for="exampleInputEmail1">Correo Electronico</label>
				    <input type="email" class="form-control" id="regEmail" aria-describedby="emailHelp" placeholder="Ingresa tu correo electronico">
				    <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu informacion con nadie.</small>

				  </div>
				  <div class="form-group passwordSection">
				    <label for="regPassword1">Contraseña</label>
				    <input type="password" class="form-control" id="regPassword1" placeholder="Ingresa tu contraseña">
				    <label for="regPassword2">Confirma tu contraseña</label>
				    <input type="password" class="form-control" id="regPassword2" placeholder="Confirma tu contraseña">
				  </div>
				  <div class="form-group nameSection">
				    <label for="regName">Nombre de usuario</label>
				    <input type="text" class="form-control" id="regName" placeholder="Nombre de Usuario">
				  </div>
				  <button id="regButton" type="button" class="btn btn-success">Registrarse</button>
				</form>
		</div>
	</section>
<?php
  $toLoadJS = Array(
     'jquery' => true,
     'logClass' => true,
     'userClass' => true,
     'alertClass' => true,
     'generals' => true,
     'loginScript' => false,
     'registerScript' => true,
     'libsTether' => false,
     'libsBootstrap' => true
      );

  $toLoadCSS = Array(
    'hometemplate' => false,
    'registertemplate' => true,
    'navbartemplate' => true
  );
  echo Autoload::loadCSS($toLoadCSS);
  echo Autoload::loadJS($toLoadJS);
?>

<?php include(HTML_DIR . 'overall/footer.php'); ?>