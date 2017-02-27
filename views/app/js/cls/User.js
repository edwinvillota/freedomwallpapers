class User {
  constructor(name, password, email, remember) {
		this.name     = name;
		this.password = password;
		this.email    = email;
		this.remember = remember || false;
		this.error 	  = false;
		if(email.trim() != '' && password.trim() != ''){
			this.login    = new Login(this);	
		} else {
			this.error = new Error('Los datos no pueden estar vacios');
		}

		
  }
}

