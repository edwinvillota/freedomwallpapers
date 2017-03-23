<?php
	/**
	* Clase Wallpaper
	*/
	class Wallpaper
	{
		# Propiedades
		public $id;
		public function getId(){
			if ($this->id == NULL){
				// Metodo para obtener el identificador
				// Consultar el id que fue asignado
				$db = new ConnectionDB();
				$dbId = $db->prepare("SELECT MAX(id) AS id FROM wallpapers");
				$dbId->execute();
				$dbId->bind_result($id);
				while($dbId->fetch()){
					$this->id = $id;
				}
				$dbId->close();
				$db->close();
				return $this->id;
			} else {
				return $this->id;
			}
		}
		public function setId($id){
			$this->id = $id;
			return;
		}

		// Usuario Uploader
		public $user_id;
		public function getUser_id(){
			return $this->user_id;
		}
		public function setUser_id($user_id){
			$this->user_id = $user_id;
		}
		// Nombre de Uploader
		public $user_name;

		// Nombre
		public $name;
		public function getName(){
			return $this->name;
		}
		public function setName($name){
			$this->name = $name;
		}

		// Categoria
		public $category_id;
		public function getCategory_id(){
			return $this->category_id;
		}
		public function setCategory_id($category_id){
			$this->category_id = $category_id;
		}

		// Nombre de categoria
		public $category_name;

		//Tags
		public $tags;
		public function getTags(){
			return $this->tags;
		}
		public function setTags($tags){
			$this->tags = $tags;
		}

		// Fecha de subida
		public $date_of_upload;
		public function getDate_of_upload(){
			return $this->date_of_upload;
		}
		public function setDate_of_upload($date_of_upload){
			$this->date_of_upload = $date_of_upload;
		}

		// Palleta de colores
		public $pallete;
		public function getPallete(){
			return $this->pallete;
		}
		public function setPallete($pallete){
			$this->pallete = $pallete;
		}

		// Propiedades de archivo
		public $fileInfo;
		public function getFileInfo(){
			return $this->fileInfo;
		}
		public function setFileInfo($fileInfo){
			$this->fileInfo = $fileInfo;
		}


		// Url
		public $url;
		public function getUrl(){
			return $this->url;
		}
		public function setUrl($rurl = NULL){
			if (is_null($rurl)){
				$base = 'wallpapers/';
				$ext = explode('.',$this->fileInfo->name)[1];
				$id = $this->getId();
				$this->url = $base . $this->getCategoryName() . '/' . $id . '.' . $ext;
				$db = new ConnectionDB();
				$stmt = $db->prepare("UPDATE wallpapers SET url = ? WHERE id = ?");
				$stmt->bind_param('si',
					$this->url,
					$this->id
					);
				if($stmt->execute()){
					return true;
				} else {
					return false;
				}
			} else {
				$this->category_name = $this->getCategoryName();
				$this->url = $rurl;
			}

			return;
		}

		// Thumbs
		public $thumbs;
		public function getThumbs(){
			return $this->thumbs;
		}
		public function setThumbs($thumbs){
			$this->thumbs = $thumbs;
		}

		// Alto
		public $height;
		public function getHeight(){
			return $this->height;
		}
		public function setHeight($height){
			$this->height = $height;
		}

		// Ancho
		public $width;
		public function getWidth(){
			return $this->width;
		}
		public function setWidth($width){
			$this->width = $width;
		}

		# Constructor
		function __construct($user_id, $name, $category_id, $tags, $date_of_upload, $pallete, $fileInfo, $height, $width)
		{
			$this->user_id = $user_id;
			$this->name = $name;
			$this->category_id = $category_id;
			$this->tags = $tags;
			$this->date_of_upload = $date_of_upload;
			$this->pallete = $pallete;
			$this->fileInfo = $fileInfo;
			$this->height = $height;
			$this->width = $width;
		}

		public function add(){
			// Obtener la conexion con el servidor
			$db = new ConnectionDB();
			// Crear la consulta preparada
			$stmt = $db->prepare("INSERT INTO wallpapers (user_id, name, category_id, tags, date_of_upload, color_vibrant, color_muted, color_lightvibrant, color_darkvibrant, color_darkmuted, size, type, height, width) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			if($stmt->bind_param('isisssssssdsii',
				$this->user_id,
				$this->name,
				$this->category_id,
				$this->tags,
				$this->date_of_upload,
				$this->pallete->Vibrant,
				$this->pallete->Muted,
				$this->pallete->LightVibrant,
				$this->pallete->DarkVibrant,
				$this->pallete->DarkMuted,
				$this->fileInfo->size,
				$this->fileInfo->type,
				$this->height,
				$this->width
				))
			{
				if($stmt->execute()){
					$this->setUrl();
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		// Metodo pora obtener el nombre de la categoria
		public function getCategoryName () {
			$db = new ConnectionDB();
			// Obtener el nombre de la categoria
			$category = $db->getArray('SELECT name FROM categories WHERE id = ' . $this->category_id);
			$categoryName = $category[0]['name'];
			return $categoryName;
		}
		// Metodo para crear las miniaturas
		public function createThumbs ($small = 576, $medium = 992, $large = 1200) {
			if(is_null($this->url)){
				return false;
			}
			// Definir la ruta del archivo
			$file = $this->url;
			// Definir el ratio de la imagen
			$ratio = $this->width / $this->height;

			// Definir la altura proporcional de las miniaturas
			$hsmall = round($small / $ratio);
			$hmedium = round($medium / $ratio);
			$hlarge = round($large / $ratio);

			// Obtener la extension del archivo
			$ext = explode(".",$file);
			$ext = strtolower($ext[count($ext) - 1]);
			if ($ext == "jpeg") $ext = "jpg";

			// Validar si existe el archivo
			if (!file_exists($file)){
				return false;
			}

			// Crear las imagenes
			switch ($ext) {
				case 'jpg':
					$img = imagecreatefromjpeg($file);
					break;

				case 'png':
					$img = imagecreatefrompng($file);
					break;

				case 'gif':
						$img = imagecreatefromgif($file);
						break;
			}

			// Crear los identificadores de recurso
			$thumb_small = imagecreatetruecolor($small,$hsmall);
			$thumb_medium = imagecreatetruecolor($medium,$hmedium);
			$thumb_large = imagecreatetruecolor($large,$hlarge);

			// Redimensionar las miniaturas
			imagecopyresampled($thumb_small, $img, 0, 0, 0, 0, $small, $hsmall, $this->width, $this->height);
   		imagecopyresampled($thumb_medium, $img, 0, 0, 0, 0, $medium, $hmedium, $this->width, $this->height);
   		imagecopyresampled($thumb_large, $img, 0, 0, 0, 0, $large, $hlarge, $this->width, $this->height);

			// Crear la carpeta de miniaturas y definir la ruta
   		$thumbsFolder = 'wallpapers/' . $this->getCategoryName() . '/thumbs';
 			if (!file_exists($thumbsFolder)){
				mkdir($thumbsFolder);
			}

			// Guardar las miniaturas
			$smallPath = $thumbsFolder . '/' . $this->id . '-small.jpg';
   		imagejpeg($thumb_small,$smallPath);
   		$mediumPath = $thumbsFolder . '/' . $this->id . '-medium.jpg';
  		imagejpeg($thumb_medium,$mediumPath);
  		$largePath = $thumbsFolder . '/' . $this->id . '-large.jpg';
   		imagejpeg($thumb_large,$largePath);

			// Registrar thumbs en la base de datos
			$db = new ConnectionDB();
			$stmt = $db->prepare("UPDATE wallpapers SET thumb_small = ?, thumb_medium = ?, thumb_large = ? WHERE id = ?");
			$stmt->bind_param('sssi',
					$smallPath,
					$mediumPath,
					$largePath,
					$this->id
			);
			if($stmt->execute()){
				return true;
			} else {
				return false;
			}
		}
		// Metodo para obtener el nombre del Usuario
		public function getUploader(){
			$username;
			$db = new ConnectionDB();
			$stmt = $db->prepare("SELECT username FROM members WHERE id = ?");
			$stmt->bind_param('i',$this->user_id);
			if($stmt->execute()){
				$stmt->bind_result($name);
				while($stmt->fetch()){
					$username = $name;
				}
				$stmt->close();
				$db->close();
				return $username;
			} else {
				$stmt->close();
				$db->close();
				return $stmt->error;
			}
		}
		// Metodo para añadir descarga
		public function addDownload($user = NULL){
			// Conectar con la base de datos
			$db = new ConnectionDB();
			// Comprobar si el usuario ya tiene registrada la descarga
			$downloaded = $db->prepare('SELECT id FROM downloads WHERE user_id = ? AND wall_id = ?');
			$downloaded->bind_param('ii',$user,$this->id);
			$downloaded->execute();
			$downloaded->store_result();
			if($downloaded->num_rows == 0){
				$downloaded->close();
				$stmt = $db->prepare('INSERT INTO downloads (wall_id,user_id) VALUES (?,?)');
				$stmt->bind_param('ii',$this->id,$user);
				if($stmt->execute()){
					$stmt->close();
					$db->close();
					return true;
				} else {
					$stmt->close();
					$db->close();
					return $stmt->error;
				};
			} else {
				$downloaded->close();
				return false;
			}

		}
		// Metodo para añadir a favoritos
		public function addFavorite($user){
			// Conectar con la base de datos
			$db = new ConnectionDB();
			// Verficar si ya esta en favoritos
			$exists = $db->prepare('SELECT id FROM favorites WHERE user_id = ? AND wall_id = ?');
			$exists->bind_param('ii',$user,$this->id);
			$exists->execute();
			$exists->store_result();
			if($exists->num_rows == 0){
				$exists->close();
				$stmt = $db->prepare('INSERT INTO favorites (user_id,wall_id) VALUES (?,?)');
				$stmt->bind_param('ii',$user,$this->id);
				if($stmt->execute()){
					$stmt->close();
					$db->close();
					return true;
				} else {
					$stmt->close();
					$db->close();
					return $stmt->error;
				}
			} else {
				return 'El wallpaper ya esta agregado a favoritos';
			}
		}
		// Metodo para añadir voto
		public function addVote($user,$type){
			// Convertir el type
			($type) ? $type = 'like' : $type = 'dislike';
			// Conectar con la base de datos
			$db = new ConnectionDB();
			//  Verficar si el wall ya fue votado
			$voted = $db->prepare('SELECT id,type FROM votes WHERE user_id = ? AND wall_id = ?');
			$voted->bind_param('ii',$user,$this->id);
			$voted->execute();
			$voted->store_result();
			if($voted->num_rows == 0){
				$voted->close();
				// Aun no fue votado
				$stmt = $db->prepare('INSERT INTO votes (user_id,wall_id,type) VALUES (?,?,?)');
				$stmt->bind_param('iis',$user,$this->id,$type);
				$stmt->execute();
				$stmt->close();
				$db->close();
				return true;
			} else {
				// Ya fue votado
				$voted->bind_result($id,$ctype);
				$voted->fetch();
				if($type != $ctype){
					// El voto actual es diferente al recibido, se debe actualizar
					$stmt = $db->prepare('UPDATE votes SET type = ? WHERE user_id = ? AND wall_id = ?');
					$stmt->bind_param('sii',$type,$user,$this->id);
					$stmt->execute();
					$stmt->close();
					$db->close();
					return true;
				} else {
					$voted->close();
					return true;
				}
			}

		}

		// Metodo que retorna las estadisticas dek wallpaper
		public function getStatistics(){
			// Conectar con la base de datos
			$db = new ConnectionDB();
			// Eleborar consulta
			$stmt = $db->prepare('SELECT	w.id,
				COUNT(DISTINCT d.id) AS Downloads,
				COUNT(DISTINCT f.id) AS Favorites,
				COUNT(DISTINCT v1.id) AS Likes,
				COUNT(DISTINCT v2.id) AS Dislikes
			FROM 	wallpapers AS w
				LEFT OUTER JOIN downloads AS d ON w.id = d.wall_id
				LEFT OUTER JOIN favorites AS f ON w.id = f.wall_id
				LEFT OUTER JOIN votes AS v1 ON w.id = v1.wall_id AND v1.type = "like"
				LEFT OUTER JOIN votes AS v2 ON w.id = v2.wall_id AND v2.type = "dislike"
			WHERE w.id = ? GROUP BY w.id;
');
			echo $db->error;
			$stmt->bind_param('i',$this->id);
			if($stmt->execute()){
				$stmt->bind_result($id,$down,$fav,$likes,$disl);
				$stmt->fetch();
				$statistics = array(
					'id' => $id,
					'downloads' => $down,
					'favorites' => $fav,
					'likes' => $likes,
					'dislikes' => $disl
				);
				return $statistics;
			} else {
				return $stmt->error;
			}

		}

		// Metodos Estaticos
		public static function getWallpaper($idWall){
			// acceder a la base de datos
			$db = new ConnectionDB();
			$stmt = $db->prepare("SELECT id,user_id,name,category_id,tags,date_of_upload,color_vibrant,color_muted,color_lightvibrant,color_darkvibrant,color_darkmuted,size,type,url,thumb_small,thumb_medium,thumb_large,height,width FROM wallpapers WHERE id = ?");
			$stmt->bind_param('i',$idWall);
			$stmt->execute();
			$stmt->bind_result($sid,$suser_id,$sname,$scategory_id,$stags,$sdate_of_upload,$scolor_vibrant,$scolor_muted,$scolor_lightvibrant,$scolor_darkvibrant,$scolor_darkmuted,$ssize,$stype,$surl,$sthumb_small,$sthumb_medium,$sthumb_large,$sheight,$swidth);
			$stmt->fetch();
			// Crear la paleta
			$spallete = new stdClass();
			$spallete->Vibrant = $scolor_vibrant;
			$spallete->Muted = $scolor_muted;
			$spallete->LightVibrant = $scolor_lightvibrant;
			$spallete->DarkVibrant = $scolor_darkvibrant;
			$spallete->DarkMuted = $scolor_darkmuted;

			// Crear el fileInfo
			$sfileInfo = new stdClass();
			$sfileInfo->name = $sname . '.jpg';
			$sfileInfo->size = $ssize;
			$sfileInfo->type = $stype;

			// Crear el thumbs
			$sthumbs = new stdClass();
			$sthumbs->small = $sthumb_small;
			$sthumbs->medium = $sthumb_medium;
			$sthumbs->large = $sthumb_large;

			$newWall = new Wallpaper($suser_id, $sname, $scategory_id, $stags, $sdate_of_upload, $spallete, $sfileInfo, $sheight, $swidth);

			$newWall->setId($sid);
			$newWall->setUrl($surl);
			$newWall->setThumbs($sthumbs);
			return $newWall;
		}
	}
?>
