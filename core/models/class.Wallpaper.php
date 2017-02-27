<?php
	/**
	* Clase Wallpaper
	*/
	class Wallpaper
	{
		# Propiedades
		protected $id;
		public function getId(){
			if ($this->id == NULL){
				// Metodo para obtener el identificador
				// Consultar el id que fue asignado
				$db = new ConnectionDB();
				$dbId = $db->prepare("SELECT id FROM wallpapers WHERE user_id = ? AND category_id = ? AND name = ? AND color_vibrant = ?");
				$dbId->bind_param('iiss',
						 $this->user_id,
						 $this->category_id,
						 $this->name,
						 $this->pallete->Vibrant
						 );
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
		protected $user_id;
		public function getUser_id(){
			return $this->user_id;
		}
		public function setUser_id($user_id){
			$this->user_id = $user_id;
		}

		// Nombre
		protected $name;
		public function getName(){
			return $this->name;
		}
		public function setName($name){
			$this->name = $name;
		}

		// Categoria
		protected $category_id;
		public function getCategory_id(){
			return $this->category_id;
		}
		public function setCategory_id($category_id){
			$this->category_id = $category_id;
		}

		//Tags
		protected $tags;
		public function getTags(){
			return $this->tags;
		}
		public function setTags($tags){
			$this->tags = $tags;
		}

		// Fecha de subida
		protected $date_of_upload;
		public function getDate_of_upload(){
			return $this->date_of_upload;
		}
		public function setDate_of_upload($date_of_upload){
			$this->date_of_upload = $date_of_upload;
		}

		// Palleta de colores
		protected $pallete;
		public function getPallete(){
			return $this->pallete;
		}
		public function setPallete($pallete){
			$this->pallete = $pallete;
		}

		// Propiedades de archivo
		protected $fileInfo;
		public function getFileInfo(){
			return $this->fileInfo;
		}
		public function setFileInfo($fileInfo){
			$this->fileInfo = $fileInfo;
		}


		// Url
		protected $url;
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
				$this->url = $rurl;
			}

			return;
		}

		// Thumbs
		protected $thumbs;
		public function getThumbs(){
			return $this->thumbs;
		}
		public function setThumbs($thumbs){
			$this->thumbs = $thumbs;
		}

		// Alto
		protected $height;
		public function getHeight(){
			return $this->height;
		}
		public function setHeight($height){
			$this->height = $height;
		}

		// Ancho
		protected $width;
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
