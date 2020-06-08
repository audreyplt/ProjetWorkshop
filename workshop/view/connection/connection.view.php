<div class="container my-4">
  <div class="row">
    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6 border-right border-dark">
      <h4 class="mb-3">Connexion</h4>

      <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= $error_message; ?>
        </div>
      <?php } ?>

      <form action="main.ctrl.php?page_type=connection" method="post">
        <div class="form-group">
          <label for="email">Login ou adresse e-mail</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text">@</div>
            </div>
            <input type="text" class="form-control" name="login" id="email" required />
          </div>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" class="form-control" name="password" id="password" required />
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
      </form>
    </article>

    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <h4>Inscription</h4>
      <p>Pas encore de compte ? inscrivez-vous dès maintenant !</p>
      <a href="main.ctrl.php?page_type=registration" class="btn btn-primary" role="button" aria-pressed="true">Créer un compte</a>
    </article>
  </div>
</div>
