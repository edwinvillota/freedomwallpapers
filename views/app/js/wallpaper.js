// Inicializar tooltips
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})

// Funcion para descargar wallpaper
// Obtener url del wallpaper
let url = document.getElementById('rsWall').src;
let a = document.getElementById('downloadBtn');
a.href = url;
let id = getParameterByName('id')
// Funcion que se ejecuta al descargar un wallpaper
document.getElementById('downloadBtn').addEventListener('click', (e) => {
  let db = new DBQuery();
  db.downloadWall(response => {
    console.log(response);
    refreshStatistics();
  },id);
});
// Funcion para agregar a favoritos
document.getElementById('addFavBtn').addEventListener('click',(e) => {
  let db = new DBQuery();
  db.addFavorite(response => {
    console.log(response);
    refreshStatistics();
  },id);
});
// Funcion para votar
let voteBtns = document.querySelectorAll('.voteBtn');
for(let i = 0; i < voteBtns.length; i++){
  voteBtns[i].addEventListener('click',(e)=>{
    let vote = e.target.dataset.vote;
    let db = new DBQuery();
    db.addVote(response => {
      console.log(response);
      refreshStatistics();
    },id,{
      'vote' : vote
    });
  });
}
// Funcion para obtener estadisticas del Wallpaper
function refreshStatistics(){
  let db = new DBQuery();
  let dCount = document.getElementById('downloadsCount');
  let fCount = document.getElementById('favoritesCount');
  let lCount = document.getElementById('likesCount');
  let disCount = document.getElementById('dislikesCount');

  db.getStatistics(response => {
    dCount.innerHTML = response.downloads;
    fCount.innerHTML = response.favorites;
    lCount.innerHTML = response.likes;
    disCount.innerHTML = response.dislikes;
  },id);
  refreshButtonsStates();
}

refreshStatistics();

// Funcion para obtener los estados de los botones de accion
function refreshButtonsStates(){
  let db = new DBQuery();
  db.getUserWallStates(response => {
    let favBtn = document.getElementById('addFavBtn');
    let likeBtn = document.getElementById('likeBtn');
    let dislikeBtn = document.getElementById('dislikeBtn');
    // Quitar los disabled
    favBtn.classList.remove('disabled');
    likeBtn.classList.remove('disabled');
    dislikeBtn.classList.remove('disabled');
    if(response.favorite){
      favBtn.classList.add('disabled');
    }
    if(response.voted){
      if(response.type == 'like'){
        likeBtn.classList.add('disabled');
      } else {
        dislikeBtn.classList.add('disabled');
      }
    }
  },id);
}

refreshButtonsStates();
