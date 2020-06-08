<div class="container mt-4">
  <h4 class="row justify-content-center">Inscription</h4>

  <?php if (isset($error_message)) { ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $error_message; ?>
    </div>
  <?php } ?>

  <form action="main.ctrl.php?page_type=registration" method="post">
    <div class="form-group">
      <label for="prenom">Nom</label>
      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Nom" required>
    </div>
    <div class="form-group">
      <label for="nom">Prénom</label>
      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Prénom" required>
    </div>
    <div class="form-group">
      <label for="email">Adresse Mail</label>
      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Entrez votre e-mail" required>
      <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre e-mail avec quelqu'un d'autre.</small>
    </div>
    <div class="form-group">
      <label for="motdepasse">Mot de passe</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
    </div>
    <div class="form-group form-check">
      <input class="form-check-input" type="checkbox" id="cgu" name="cgu" required />
      <label class="form-check-label" for="cgu">Vous accceptez le contrat général d'utilisation</label>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
  </form>

  <p class="row justify-content-center">Déjà un compte ?&nbsp;<a href="main.ctrl.php?page_type=connection">Connectez-vous</a>&nbsp;!</p>
</div>
