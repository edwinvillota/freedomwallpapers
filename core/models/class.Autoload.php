<?php 
		
	/**
	* Clase encargada de cargar los scripts
	*/
	class Autoload
	{
		
    
		public static function loadJS($toLoad) {
			// Definir los scripts a cargar 
			$jquery = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js";
			// Classes javascript
			$logClass = "views/app/js/cls/Log.js";
			$userClass = "views/app/js/cls/User.js";
			$alertClass = "views/app/js/cls/Alert.js";
			$dropareaClass = "views/app/js/cls/Droparea.js";
			$dbQuery = "views/app/js/cls/DBQuery.js";
			// Funciones generales
			$generals = "views/app/js/generals.js";
			// Funciones de logeo y registro
			$loginScript = "views/app/js/login.js";
			$registerScript = "views/app/js/register.js";
			// Script de droparea
			$dropWallpaper = "views/app/js/dropWallpaper.js";	
			// Bootstrap
			// Tether
			$libsTether = "https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js";

			$libsBootstrap = "views/libs/bootstrap/js/bootstrap.min.js";
			// Droparea
			$libsDroparea = "views/libs/droparea/droparea.js";
			// Color-Thief
			$libsVibrant = "views/libs/vibrant/dist/Vibrant.min.js";
			$libsFileInput = "views/libs/bootstrap/js/bootstrap.file-input.js";
	
			// Array de enlaces
			$src = Array(
				'jquery' => $jquery,
				'logClass' => $logClass,
				'userClass' => $userClass,
				'alertClass' => $alertClass,
				'dropareaClass' => $dropareaClass,
				'dbQuery' => $dbQuery,
				'generals' => $generals,
				'loginScript' => $loginScript,
				'registerScript' => $registerScript,
				'dropWallpaper' => $dropWallpaper,
				'libsTether' => $libsTether,
				'libsBootstrap' => $libsBootstrap,
				'libsDroparea' => $libsDroparea,
				'libsVibrant' => $libsVibrant,
				'libsFileInput' => $libsFileInput
				);


			/* Plantilla del array $toLoadJS obtenido
				$toLoad = Array(
					'jquery' => true,
					'logClass' => true,
					'userClass' => true,
					'alertClass' => true,
					'dropareaClass' => true,
					'dbQuery' => true,
					'generals' => true,
					'loginScript' => true,
					'registerScript' => true,
					'dropWallpaper' => $dropWallpaper,
					'libsTether' => true,
					'libsBootstrap' => true,
					'libsDroparea' => true,
					'libsVibrant' => true,
					'libsFileInput' => true
					);
			*/		

			$html = '';

			foreach ($toLoad as $key => $value) {
				if ($value) {
					$script = '	<script src="' . $src[$key] . '"></script>' . "\n";
					$html = $html . $script;
				}
			}

			return $html;

		}

		public static function loadCSS($toLoad){
			// Definir las rutas de los estilos
			// Plantillas de paginas
			$hometemplate ='views/app/css/hometemplate.css';
			$registertemplate = 'views/app/css/registertemplate.css';
			$addWallpapertemplate = 'views/app/css/addWallpapertemplate.css';
			// Plantilla del menu de navegacion
			$navbartemplate = 'views/app/css/navbartemplate.css';
			// Plantillas de librerias
			// FontAwesome
			$fontawesome = "views/libs/font-awesome/css/font-awesome.min.css";


			// Array de enlaces
			$href = Array(
				'hometemplate' => $hometemplate,
				'registertemplate' => $registertemplate,
				'addWallpapertemplate' => $addWallpapertemplate,
				'navbartemplate' => $navbartemplate,
				'fontawesome' => $fontawesome
				);
			/* Plantilla del array $toLoadCSS obtenido
				$toLoad = Array(
					'hometemplate' => false,
					'registertemplate' => false,
					'addWallpapertemplate' => false,
					'navbartemplete' => false,
					'fontawesome' => false
					);
			*/
			$html = '';
			foreach ($toLoad as $key => $value) {
				if($value){
					$style = '<link href="' . $href[$key] . '" rel="stylesheet">' . "\n";
					$html = $html . $style;
				}
			}

			return $html;
		}
	}

?>