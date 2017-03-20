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
  },id);
});
