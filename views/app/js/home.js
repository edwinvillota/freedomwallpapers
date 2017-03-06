window.addEventListener('load',function(){
  let db = new DBQuery();
  db.getRecent(response => {
    for(let key in response){
      card = new Card(response[key]);
      card.append('.card-columns')
    }
  });
},false);
