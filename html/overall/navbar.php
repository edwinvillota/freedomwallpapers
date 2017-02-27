<header>
  <nav class="navbar navbar-toggleable-md navbar-light fixed-top bg-faded" >
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="?view=index" target="_self">
      <img src="images/icons/mainIcon.svg" class="d-inline-block align-top" alt="Freedom Wallpapers" style="width: 2rem">
      <?php echo APP_TITLE ?>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="userMenuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
            if(isset($_SESSION['user'])){
              $s = unserialize($_SESSION['user']);
              echo $s->getName();
            } else {
              echo "Usuario";
            }
           ?>
          </a>
        <div class="dropdown-menu" aria-labelledby=" navbarDropdownMenuLink" id="userMenu">
          <a class="dropdown-item" href="?view=addWallpaper">Subir Wallpaper</a>
          <a class="dropdown-item" href="#">Perfil</a>
          <a class="dropdown-item" href="#">Favoritos</a>
          <a class="dropdown-item" href="" target="_self" id="logoutBtn">Salir</a>
        </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Inicio<span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Categorias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Perfil</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text"   placeholder="Busqueda">
        <button class="btn btn-outline-info my-2 my-sm-0 mr-2" type="button">Buscar</button>
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="modal" data-target="#loginFormModal" id="btnOpenLog">Login</button>
        <!-- Modal -->
        <div class="modal fade" id="loginFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control w-100 mb-sm-2" id="logEmail" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control w-100 mb-sm-2" id="logPassword" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2">Recordarme</label>
                        <div class="col-sm-10">
                    <div class="form-check form-check-inline d-inline-block">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="" id="logRemember">
                      </label>
                  </div>
                        </div>
                    </div>


                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10 ">
                        <button type="button" class="btn btn-outline-success float-right ml-2" id="loginButton">Ingresar</button>
                          <a target=_self href="?view=register" class="btn btn-outline-warning float-right" role="button" aria-pressed="true">Registrarse</a>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
             </div>

            </div>
          </div>
      </form>
    </div>
  </nav>
</header>
