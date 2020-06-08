<div class="container mt-4">
  <div class="row justify-content-center">
    <h1>Mot de passe oublié ?</h1>
  </div>

  <?php if (isset($error_message)) { ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $error_message ?>
    </div>
  <?php } ?>

  <div class="row justify-content-center">
    <form class="col-8 mt-3" action="main.ctrl.php?page_type=forgot_password" method="post">
      <div class="form-group">
        <label for="email">L'adresse e-mail de votre compte</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">@</div>
          </div>
          <input type="email" class="form-control" name="email" id="email" required />
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </div>
    </form>
  </div>
</div>
