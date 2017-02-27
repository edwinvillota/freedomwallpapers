<?php

/**
* Clase usuario
*/
class User
{

	# Propiedades

	protected $id;
	public function getId(){
		return $this->id;
	}

	// Nombre
	protected $name;
	public function getName(){
		return $this->name;
	}

	// Email
	protected $email;
	public function getEmail(){
		return $this->email;
	}

	// Password
	protected $password;

	// El usuario existe
	protected $exists;


	// ValidState Estado de validacion
	protected $validState;


	# Constructor

	public function __construct($name, $email, $password){
		$this->name     = $name;
		$this->email    = $email;
		$this->password = hash('sha512',$password);
		$this->exist 	= false;
		$this->validState = false;
	}

	# Metodos

	# Metodos Privados

	public function validateLogin(){
		$db = new ConnectionDB();
		// Consulta preparada
		$stmt = $db->prepare("SELECT * FROM members WHERE email COLLATE utf8_bin = ? AND password COLLATE utf8_bin = ?");
		$pass = $this->password;
		$stmt->bind_param('ss',$this->email,$pass);
		$stmt->execute();
		$stmt->bind_result($id, $name, $email, $password, $salt, $date);
		// Obtener los valores
		while($stmt->fetch()){
			$this->id = $id;
			$this->name = $name;
		}
		$stmt->store_result();
		// Si el numero de filas resultado es diferente a 1
		if($stmt->num_rows != 1){
			$stmt->free_result();
			$stmt = $db->prepare("SELECT * FROM members WHERE email COLLATE utf8_bin = ?");
			$stmt->bind_param('s',$this->email);
			if($stmt->execute()){
				$stmt->bind_result($id, $name, $email, $password, $salt, $date);
			} else {
				echo $stmt->error;
			}
			$stmt->store_result();
			// Verificar si existe el usuario cambiando el password a *
			if($stmt->num_rows == 1){
				$this->exists = true;
				return false;
			} else {
				// No existe el usuario;
				$this->exists = false;
				$this->validState = false;
				return false;
			}
		} else {
			// El login es valido existe usuario y contraseña es correcta
			$this->validState = true;
			$stmt->close();
			$db->close();
			return true;
		}
		$stmt->close();
		$db->close();
	}

	private function validateRegister(){
		$db = new ConnectionDB();
		// Estados para verificar
		$states = Array(
			'emailE' => true,
			'nameE'  => true
		);

		$this->validateLogin(); // Ejecutar la validacion del logeo para actualizar estados

		// Verificar si el usuario ya esta en uso
		$stmt = $db->prepare("SELECT * FROM members WHERE email = ?");
		$stmt->bind_param('s',$this->email);
		$stmt->execute();
		$stmt->bind_result($id, $name, $email, $password, $salt, $date);
		$stmt->store_result();

		if($stmt->num_rows == 0) {
			// El email no esta en uso
			$states['emailE'] = false;
		} else {
			// EL email ya esta en uso
			$states['emailE'] = true;
		}


		// Verificar si el usuario ya esta en uso
		$stmt = $db->prepare("SELECT * FROM members WHERE username = ?");
		$stmt->bind_param('s',$this->name);
		$stmt->execute();
		$stmt->bind_result($id, $name, $email, $password, $salt, $date);
		$stmt->store_result();

		if($stmt->num_rows == 0) {
			// El nombre de usuario no esta en uso
			$states['nameE'] = false;
		} else {
			// EL nombre de usuario ya esta en uso
			$states['nameE'] = true;
		}

		$stmt->close();
		$db->close();

		return $states;
	}

	# Metodos Publicos

	public function login(){
		if($this->validateLogin()){
			if($this->validState){
				return true;
			}
		} else {
			return false;
		}
	}

	public function validateData(){
		$result = Array(
			'success' => false, // Si todos lo datos son validos
			'message1' => '', // El mensaje de error 1
			'message2' => '', // El mensaje de error 2
			'n_error' => 0 // El numero de errores encontrados
		);

		$states = $this->validateRegister();

		if(!$states['emailE'] && !$states['nameE']){
			// El email y la contraseña estan disponibles

			// Registrar el usuario
			$db = new ConnectionDB();
			$stmt = $db->prepare("INSERT INTO members (username, email, password, salt, registration_date) VALUES (
				?, ?, ?, ?, ?)");
			$stmt->bind_param('sssss',$this->name,$this->email,$this->password,$this->password,$date);
				$date = date('y\-m\-d');

			if(!$stmt->execute()){
				$result['success'] = false;
				$result['message'] = 'Error al insertar registro';
			}


			// Actualizar las variables de estado
			$result['success'] = true;
			$result['message'] = 'Los datos fueron verificados';
			return $result;

		}
		if ($states['emailE']){
			// El correo ya esta en uso
			$result['message1'] = 'El email ya fue registrado';
			$result['n_error'] += 1;
		}
		if ($states['nameE']){
			// El nombre de usuario ya esta en uso
			$result['message2'] = 'El nombre de usuario ya esta en uso';
			$result['n_error'] += 2;
		}

		return $result;
	}

	public function logout() {
		$_SESSION = Array();
		$params = session_get_cookie_params();
		setcookie(session_name(),
	       '', time() - 42000,
           $params["path"],
	       $params["domain"],
           $params["secure"],
		   $params["httponly"]);
		session_destroy();
		return true;
	}

}


?>
