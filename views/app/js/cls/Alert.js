class Alert{
	constructor(type,strong,message){
		this.type    = type || (type = success);
		this.strong  = strong;
		this.message = message;
	}

	append(container){
		var alert = $('<div class="mt-2 alert alert-' + this.type + ' alert-dismissible fade show" role="alert">' +
  					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                      '<span aria-hidden="true">&times;</span>' +
  					  '</button>' +
  					  '<strong>' + this.strong + '</strong>' + this. message +
					  '</div>');
		$(container).append(alert);
	}
}