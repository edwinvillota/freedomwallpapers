class Droparea {
	// Contructor
	constructor($elClass, overCSS, leaveCSS, dropCSS, $uploadId, callback){
		this.$elClass = document.querySelector($elClass);
		this.$uploadBtn = document.getElementById($uploadId);
		this.overCSS = overCSS;
		this.leaveCSS = leaveCSS;
		this.dropCSS = dropCSS;
		this.callback = callback;
		this.fileInfo = false;
		this.img = false;
		this.pallete = false;
		this.dataTransfer = {};
		this.bindEvents();
	}

	// Metodos 
	bindEvents(){
		// Cuando el raton entra arrastrando
		this.$elClass.addEventListener('dragover', this.over.bind(this));
		// Cuando el raton sale
		this.$elClass.addEventListener('dragleave', this.leave.bind(this));
		// Cuando el elemento es soltado
		this.$elClass.addEventListener('drop', this.drop.bind(this));
		// Cuando se pulsa el boton de subir
		this.$uploadBtn.addEventListener('click', this.upload.bind(this));
	}

	over(e){
		e.preventDefault();
		this.$elClass.classList.add(this.overCSS);
		this.$elClass.classList.remove(this.dropCSS);
	}

	leave(e){
		e.preventDefault();
		this.$elClass.classList.remove(this.overCSS);
		this.$elClass.classList.add(this.leaveCSS);
	}

	drop(e,callback = this.callback){
		e.preventDefault();
		this.$elClass.classList.remove(this.overCSS);
		this.$elClass.classList.add(this.dropCSS);
		this.$elClass.innerHTML = '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>';
		this.toBase64(e).then(str => {

			new Promise(done => {
				let img = new Image();
				img.onload = function(){
					done(this);
				}
				img.src = str;
			}).then(d => {
				this.img = d;
				if(typeof e.dataTransfer === "undefined"){
					var file = e.target.files[0];
				} else {
					var file = e.dataTransfer.files[0];	
					document.getElementById('wallInputBtn').value = "";
				}
				this.fileInfo = {
					name : file.name,
					size : (file.size / 1024 / 1024).toFixed(2),
					type : file.type
				}
				this.$elClass.textContent = '';
				this.$elClass.style.backgroundImage = `url(${this.img.src})`;
				this.$elClass.dataset.name = this.fileInfo.name;
				this.$elClass.dataset.type = this.fileInfo.type;
				this.$elClass.dataset.size = this.fileInfo.size;
				this.$elClass.dataset.width = this.img.width;
				this.$elClass.dataset.height = this.img.height;

				// Obteniendo la paleta de colores

				let v = new Vibrant(this.img);
				let swatches = v.swatches();
				let pallete = {};
				for (var swatch in swatches){
					if(swatches.hasOwnProperty(swatch) && swatches[swatch]){
						pallete[swatch] = swatches[swatch].getHex().replace('#','');
					}
				}
				this.pallete = pallete;

				this.dataTransfer = {};

				return callback(this);
			});

		}).catch(error => {
			this.$elClass.style.backgroundImage = '';
			this.$elClass.innerHTML = error.message;			
		});
	}

	toBase64(e) {
		return new Promise((resolve, reject) => {
			let fileReader = new FileReader();
			if(typeof e.dataTransfer === "undefined"){
				var file = e.target.files[0];
			} else {
				var file = e.dataTransfer.files[0];	
			}
			if(file.type.split("/")[0] == 'image'){
				fileReader.onload = function () {
				resolve(this.result);
				}
				fileReader.readAsDataURL(file);				
			} else {
				reject(new Error(`<h1 class=h3> No puedes subir archivos de este tipo <strong>${file.type.split("/")[0]}</strong></h1>`));
			}

		});	
	}

	upload(e){
		// Borrando los alert anteriores
		$('.wallInfoSection .alert').remove();

		// Obteniendo los valores del formulario
		let cont = $('.wallInfoSection .container');
		let iName = document.getElementById('wallNameInput');
		let iCategory = document.getElementById('selectCategory');
		let a = new Alert('success','Excelente!! ','El Wallpaper se agrego correctamente');

		if (iName.value.trim() === ''){
			iName.focus();
			return false;
		} else if (iCategory.value == 0){
			iCategory.focus();
			return false;
		} else if(this.img && this.pallete && this.fileInfo){
			return new Promise((resolve,reject) => {
				$.ajax({
					url: 'ajax.php',
					type: 'POST',
					dataType: 'json',
					data: { 
						'mode': 'uploadWallpaper',
						'name': iName.value,
						'category': iCategory.value,
						'wall' : JSON.stringify(this),
						'img' : JSON.stringify({
							'src': this.img.src,
							'height': this.img.height,
							'width' : this.img.width
						})
					},
				})
				.done(function(response) {
					resolve(response);
				})
				.fail(function(jqXHR,message,ehttp) {
					reject(new Error(message + ' : ' + ehttp));
				});
				
			}).then(response => {
				console.log(response);
				if(response){
					a.append(cont);
					this.destroy(e);
				} else {
					a.type = "danger";
					a.strong = "Error: "
					a.message = "No se pudo subir la imagen a la base de datos";
				}
			}).catch(error => {
				this.destroy(e);
				console.log(error.message);
			});
		} else {
			a.type = "danger";
			a.strong = "Error: ";
			a.message = 'Aun no se ha cargado ninguna imagen.';
			a.append(cont);
		}
	}

	destroy(e){
		e = null;
		this.img = null;
		this.pallete = null;
		this.dataTransfer = null;
		let iName = document.getElementById('wallNameInput');
		let iCategory = document.getElementById('selectCategory');
		iName.value = '';
		iCategory.value = 0;
		document.querySelector('.file-input-wrapper span').innerHTML = 'Examinar';
		this.$elClass.style.backgroundImage = '';
		document.getElementById('pallete').style.background = '';
	}

}