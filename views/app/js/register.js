// Validaciones de formulario
document.getElementById('regButton').addEventListener('click',function(){
	// Remover alertas anteriores
	$('#regForm .alert').remove();

	// Variables a validar
	var isValidEmail    = false;
	var isValidPassword = false;
	var isValidName     = false;
	var emailExists		= true;
	var nameExists		= true;


	var a = new Alert('danger','Error: ','');
	// Validar Correo electronico
	var email = document.getElementById('regEmail');
	if(validEmail(email.value)){
		// Accion cuando el correo es valido
		idValidEmail = true;
	} else {
		// Accion cuando el correo no es valido
		email.focus();
		a.message = 'El correo que ingresaste no es valido';
		a.append($('#regForm .emailSection'));
	}


	// Validar password

	var pass1 = document.getElementById('regPassword1');
	var pass2 = document.getElementById('regPassword2');

	// Confirmar que coinciden
	if(pass1.value === pass2.value && pass1.value.trim() != ''){
		isValidPassword = true;
	} else if (pass1.value.trim() == '' && pass2.value.trim() == '') {
		a.message = 'Las contraseñas no pueden estar vacias';
		a.append($('#regForm .passwordSection'));
	} else {
		pass1.value = '';
		pass2.value = '';
		pass1.focus();
		a.message = 'Las contraseñas no coinciden';
		a.append($('#regForm .passwordSection'));
	}

	// Validar usuario
	var name = document.getElementById('regName');

	if(name.value.trim() != ''){
		// El nombre no esta vacio
		isValidName = true;
	} else {
		name.focus();
		a.message = 'El nombre no puede estar vacio';
		a.append($('#regForm .nameSection'));
	}


	// Validar si usuario y email no esten en uso

	if(isValidEmail,isValidName,isValidPassword){
		var u = new User(name.value, pass1.value, email.value, false);
		var result = u.login.reg();
		switch(result['n_error']){
			case 0:
				a.type = 'success';
				a.message = 'El usuario se registro Exitosamente';
				a.append($('#regForm'));
				setTimeout(function(){
					window.location = "index.php";
				},3000);
				break;
			case 3:
				a.message = 'El nombre de usuario <strong>' + name.value + '</strong> ya esta en uso.';
				a.append($('#regForm .nameSection'));

			case 1: 
				a.message = 'El email <strong>' + email.value + '</strong> ya esta en uso.';
				a.append($('#regForm .emailSection'));				
				break;

			case 2: 
				a.message = 'El nombre de usuario <strong>' + name.value + '</strong> ya esta en uso.';
				a.append($('#regForm .nameSection'));
				break;
		}
	}



},false);


