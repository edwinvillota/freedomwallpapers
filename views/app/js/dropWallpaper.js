window.addEventListener('load',function(){
	$('body').addClass('bg-inverse');

	drop = new Droparea('.droparea','overCSS','leaveCSS','dropCSS','uploadBtn',function(Wall){
		let cont = document.getElementById('pallete');
		let length = (100 / Object.keys(Wall.pallete).length);
		length = length;
		let percent = 0;
		let deg = 'linear-gradient(90deg';
		for(var key in Wall.pallete){
			let e = document.createElement("div");
			deg += ',#' + Wall.pallete[key] + ' ' + percent.toFixed(0) + '%' + ',#' + Wall.pallete[key] + ' ' + (percent + length).toFixed(0) + '%';
			percent += length;
		}
		deg += ')';
		cont.style.background = deg;
		$('.file-input-wrapper span').text(Wall.fileInfo.name);
	});
	

	$('input[type=file]').bootstrapFileInput();
	// Definir funcionalidad para el boton examinar
	document.getElementById('wallInputBtn').addEventListener('change',function(e){
		e.preventDefault();
		drop.drop(e);
	});	




	// Cargar las categorias
	var db = new DBQuery();
	db.getCategories(result => {
		for(let key in result){
			let select = document.getElementById('selectCategory');
			let option = document.createElement('option');
			option.value = result[key].id;
			option.innerHTML = result[key].name;
			select.appendChild(option);
		}
	});
});
