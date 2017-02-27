<?php
/*
Nucleo de la aplicacion

Se registra el autoloader
*/

spl_autoload_register(function($class){
	include_once 'core/models/class.'.$class.'.php';
});


// Definir zona horaria

date_default_timezone_set('America/Bogota');

/*
Se definen constantes
*/

header("access-control-allow-origin: *");
# Constantes de la Base de Datos
define('DB_HOST','localhost');
define('DB_USER','sec_user');
define('DB_PASSWORD','nK6BzLQztXX9U9yNHpTv');
define('DB_NAME','freedomwallpapers');
define('CAN_REGISTER','any');
define('DEFAULT_ROLE','member');
define('SECURE',FALSE);

# Constantes de Aplicacion
define('HTML_DIR','html/');
define('APP_TITLE','Freedom Wallpapers');
define('APP_URL','http://freedomwallpapers.com/');

require('vendor/autoload.php');

// Funcion de inicio de sesion seguro
include('core/bin/functions/sec_session.php');

?>
