<!-- HEADER -->
<nav class="navbar navbar-expand-xl sticky-top navbar-dark bg-dark py-1 shadow-lg">
  <a class="navbar-brand" href="main.ctrl.php"><img src="../view/resources/img/logo.png" alt="logo photoweb"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarToggler">
    <!-- NAVIGATOR -->
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <div class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Catégories
          </a>
          <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="main.ctrl.php?page_type=category&category=photo_books">Livres Photos</a>
            <a class="dropdown-item" href="main.ctrl.php?page_type=category&category=calendars_and_diaries">Calendriers & Agendas</a>
            <a class="dropdown-item" href="main.ctrl.php?page_type=category&category=photo_printing">Tirages Photo</a>
            <a class="dropdown-item" href="main.ctrl.php?page_type=category&category=wall_decor">Déco Murale <span class="badge badge-secondary">New</span></a>
            <a class="dropdown-item" href="main.ctrl.php?page_type=category&category=greeting_cards">Cartes de voeux</a>
            <a class="dropdown-item" href="main.ctrl.php?page_type=category&category=objects_and_decor">Objets & Déco <span class="badge badge-secondary">New</span></a>
          </div>
        </div>
      </li>
    </ul>

    <!-- SEARCH BAR -->
    <div class="col-xl-5 mr-3">
      <form method="" action=""> <!-- A compléter -->
        <div class="input-group">
          <input type="search" class="form-control my-sm-2" placeholder="Rechercher un template, un utilisateur, ..." aria-label="search_bar" aria-describedby="button-addon">
          <div class="input-group-append my-sm-2">
            <button class="col-lg-12 btn btn-light border-left" type="submit" id="button-addon"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>

    <?php if (isset($_SESSION['id'])): ?>
      <!-- BUTTONS CONNECTED -->
      <div class="row justify-content-center my-2 my-xl-0">
        <a class="btn btn-danger mr-2" href="main.ctrl.php?page_type=notification" role="button" aria-pressed="true"><i class="fas fa-bell"></i></a> <!-- A compléter -->
        <div class="btn-group mr-2">
          <a class="btn btn-outline-warning" href="main.ctrl.php?page_type=profil" role="button" aria-pressed="true"><i class="fas fa-user-circle"></i>
            <?= $superManager->getUser($_SESSION['id'])->getPseudo() ?>
          </a>
          <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" id="connectedDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
          <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="connectedDropdown">
            <a class="dropdown-item" href="main.ctrl.php?page_type=profil">Espace membre</a>
            <a class="dropdown-item" href="main.ctrl.php?page_type=templates">Mes templates</a> <!-- A compléter -->
            <a class="dropdown-item" href="main.ctrl.php?page_type=notification">Notifications</a> <!-- A compléter -->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="main.ctrl.php?page_type=disconnection"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
          </div>
        </div>
        <a class="btn btn-success mr-3" href="main.ctrl.php?page_type=profil" role="button" aria-pressed="true"><i class="fas fa-upload"></i> Publier</a> <!-- A compléter -->
      </div>
    <?php else: ?>
      <!-- BUTTONS DISCONNECTED -->
      <div class="row justify-content-center mr-2 my-2 my-xl-0">
        <div class="btn-group">
          <a class="btn btn-outline-warning" href="main.ctrl.php?page_type=connection" role="button" aria-pressed="true"><i class="fas fa-users"></i> Se connecter</a>
          <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
          <div class="dropdown-menu dropdown-menu-lg-right">
            <form class="container-fluid px-4 py-3" action="main.ctrl.php?page_type=connection" method="post">
              <p class="row justify-content-center font-weight-bold">Connexion</p>
              <div class="form-group">
                <input type="text" class="form-control" name="login" placeholder="Login" required />
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required />
              </div>
              <div class="row justify-content-center">
                <button type="submit" class="col-6 align-self-center btn btn-primary">Se connecter</button>
              </div>
            </form>
            <div class="dropdown-divider"></div>
            <div class="mx-4">
              <p class="text-nowrap mb-0">Nouveau parmi nous ? <a href="main.ctrl.php?page_type=registration">S'inscrire</a><br /></p>
              <a class="text-nowrap" href="main.ctrl.php?page_type=forgot_password">Mot de passe oublié ?</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</nav>
