window.addEventListener('load',function(){
	// Login
	$('#loginButton').on('click',function(){
		// Crear el objeto usuario
		var uEmail = document.getElementById('logEmail').value;
		var uPassword = document.getElementById('logPassword').value; 
		var uRemember = document.getElementById('logRemember').checked;
		var u = new User('', uPassword, uEmail, uRemember);
		try{
			if(!u.error){
				var a = new Alert('success','Bienvenido: ','Ingreso Correctamente');
				if(u.login.in()){
					a.append($('#loginFormModal .modal-content'));
					location.reload();
				} else {
					a = new Alert('danger','Error: ','Credenciales Incorrectas');
					a.append($('#loginFormModal .modal-content'));	
				}
			} else {
				var a = new Alert('danger','Error ','Los datos no pueden estar vacios');
				a.append($('#loginFormModal .modal-content'));
			}
		} catch(e) {
			console.log(e.message);
		}
		
	});

	// Definiendo el metodo de salida al boton salir

	$('#logoutBtn').on('click',function(){
		var u = new User('test','test','test',false);
		if(u.login.out()){
			location.reload();
		}
	});


},false);