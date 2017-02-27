class Login {
  constructor(u) {
    this.user = JSON.stringify(u);
  }

// Metodos
  access(mode, callback){
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      async: false,
      cache: false,
      dataType: 'json',
      data: {
        'mode'      : mode,
        'user'      : this.user
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

  in(){
    var result;
    this.access('login',function(r){
      var response = r;
      result = response;
      return;
    });

    return result;
  }

  reg(){
    var result;
    this.access('register',function(response){
      result = response;
    });
    return result;
  }

  out(){
    var result;
    this.access('logout',function(response){
      result = response;
    })
    return result;
  }

}
