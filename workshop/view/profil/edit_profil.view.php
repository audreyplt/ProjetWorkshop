<div class="container mt-4">
  <h4 class="row justify-content-center mb-3">Modification de votre profil</h4>

  <?php if (isset($error_message)): ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $error_message; ?>
    </div>
  <?php endif; ?>

  <form action="main.ctrl.php?page_type=profil" method="post">
    <div class="form-group">
      <label for="u_pseudo">Pseudo</label>
      <input type="text" class="form-control" name="u_pseudo" id="u_pseudo" value="<?= $user->getPseudo() ?>" required />
    </div>

    <div class="form-group">
      <label for="u_email">Adresse e-mail</label>
      <input type="email" class="form-control" name="u_email" id="u_email" value="<?= $user->getEmail() ?>" required />
    </div>

    <div class="form-group">
      <label for="u_password">Mot de passe</label>
      <input type="text" class="form-control" name="u_password" id="u_password" value="<?= $user->getPassword() ?>" required />
    </div>

    <div class="form-group">
      <label for="u_city">Ville</label>
      <input type="text" class="form-control" name="u_city" id="u_city" value="<?= $user->getCity() ?>" required />
    </div>

    <div class="form-group">
      <label for="u_country">Pays</label>
      <select id="u_country" name="u_country" class="form-control" required>
        <option>France</option>
        <option>Allemagne</option>
        <option>Espagne</option>
        <option>Royaume-Unis</option>
        <option>Etats-Unis</option>
      </select>
    </div>

    <div class="form-group">
      <label for="u_resume">Description</label>
      <textarea class="form-control" name="u_resume" id="u_resume" required><?= $user->getResume() ?></textarea>
    </div>

    <input type="hidden" name="action" value="edit_profil_done" />

    <button type="submit" class="btn btn-primary">Valider</button>
    <a class="btn btn-warning mr-3" href="main.ctrl.php?page_type=profil" role="button" aria-pressed="true"><i class="fas fa-user-circle"></i> Page de profil</a>
  </form>
</div>
