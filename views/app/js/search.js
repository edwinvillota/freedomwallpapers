// let db = new DBQuery();
// db.getRecent(response => {
//   for(let key in response){
//     card = new Card(response[key]);
//     card.append('.card-columns');
//   }
// });

document.getElementById('searchBtn').addEventListener('click',function(){
// Obtener los inputs de busqueda
  let keywordi = document.getElementById('keywordInput');
  let categoryi = document.getElementById('categoryInput');
  let byColori = document.getElementById('byColorInput');
  let colori = document.getElementById('colorInput');
  let sorti = document.getElementById('sortInput');

  let s = new Search(keywordi.value,categoryi.value,byColori.checked,colori.value,sorti.value);
  s.execute();
},false);
