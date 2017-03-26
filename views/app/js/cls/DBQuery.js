class DBQuery {
	constructor(){

	}

	access(mode,callback,id = false,params = {}){
		$.ajax({
	      url: 'ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: {
	        'mode'      : mode,
					'id'				: id,
					'params'		: params
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

	addFavorite(callback,id){
		this.access('addFavorite', response => {
			callback(response);
		},id);
	}

	addVote(callback,id,params){
		this.access('addVote', response => {
			callback(response);
		},id,params);
	}

	getStatistics(callback,id){
		this.access('getStatistics', response => {
			callback(response);
		},id);
	}

	getUserWallStates(callback,id){
		this.access('getUserWallStates', response => {
			callback(response);
		},id)
	}
}
