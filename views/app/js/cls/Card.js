class Card {
  constructor(wall){
    this.el =  $('<a href=?view=wallpaper&id=' + wall.id + '><div class="card card-inverse mb-2">' +
               '<img class="card-img-top img-fluid" src="' + wall.thumbs.small + '" alt="' + wall.name + '">' +
               '<div class="card-block">' +
               '<h4 class="card-title">' + wall.name + '</h4>' +
               '<p class="card-text">' +
               '<span style="color:#' + wall.pallete.Vibrant + '">Categoria: </span>' + wall.category_name + '</br>' +
               '<span style="color:#' + wall.pallete.Vibrant + '">Dimensiones: </span>' + wall.width + 'x' + wall.height +
               '</p>' +
               '</div>' +
               '</div></a>');
  }

  append($cont){
    $($cont).append(this.el);
  }

}
