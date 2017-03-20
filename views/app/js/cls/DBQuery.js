class DBQuery {
	constructor(){

	}

	access(mode,callback,id = false){
		$.ajax({
	      url: 'ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: {
	        'mode'      : mode,
					'id'				: id
	      }
	    })
	      .done(function(response) {
	        callback(response);

	    })
	     .fail(function(jqXHR,message,ehttp) {
	        var e = new Error(message + ' ' + ehttp);
	        callback(e);
	    })
	     .always(function() {
	    });
	}

	getCategories(callback){
		this.access('loadCategories',response => {
			callback(response);
		});
	}

	getRecent(callback){
		this.access('getRecent',response => {
			callback(response);
		});
	}

	downloadWall(callback,id){
		this.access('downloadWall', response => {
			callback(response);
		},id);
	}
}
