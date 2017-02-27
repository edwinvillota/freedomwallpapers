<?php 

	/**
	* Clase de conexion a la base de datos
	*/
	class ConnectionDB extends mysqli
	{
		
		function __construct()
		{
			parent::__construct(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
			$this->connect_errno ? die('No se pudo conectar con la base de datos') : null;
			$this->set_charset("utf8");
		}

		// Metodo para hacer consultas

		public function getArray($query){
			$return = array();
			if($result = $this->query($query)){
				while($row = $result->fetch_assoc()){
					array_push($return, $row);
				}
			}
			$this->close();
			return $return;
			mysqli_free_result($query);
		}

		// Retorna el numero de filas resultado
		public function rows($query){
			return mysqli_num_rows($query);
		}

		// Libera la memoria asociada a una consulta
		public function freeQuery($query){
			return mysqli_free_result($query);
		}

		// Recorrer el array
		public function throught($query){
			return mysqli_fetch_array($query);
		}



	}

?>