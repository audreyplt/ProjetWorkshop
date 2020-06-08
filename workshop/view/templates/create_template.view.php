<div class="container mt-4">
  <h4 class="row justify-content-center mb-3">Création d'un template</h4>
  <div class="row justify-content-center align-items-start">
    <img src="../view/resources/img/templates/template_photo_books.png" class="img-fluid" alt="template_albumPhoto" width="250" height="200">
  </div>

  <?php if (isset($error_message)): ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $error_message; ?>
    </div>
  <?php endif; ?>

  <form action="main.ctrl.php?page_type=profil" method="post">
    <div class="form-group">
      <label for="t_name">Nom du template</label>
      <input type="text" class="form-control" name="t_name" id="t_name" required />
    </div>

    <div class="form-group">
      <label for="t_description">Description</label>
      <textarea class="form-control" name="t_description" id="t_description" required></textarea>
    </div>

    <div class="form-group">
      <label for="t_size">Taille</label>
      <select id="t_size" name="t_size" class="form-control" required>
        <option>S</option>
        <option>M</option>
        <option>L</option>
      </select>
    </div>

    <div class="form-group">
      <label for="t_format">Format</label>
      <select id="t_format" name="t_format" class="form-control" required>
        <option>Portrait</option>
        <option>Carré</option>
        <option>Paysage</option>
      </select>
    </div>

    <div class="form-group">
      <label for="t_topic">Thème</label>
      <select id="t_topic" name="t_topic" class="form-control" required>
        <option>Voyage</option>
        <option>Vacances</option>
        <option>Mariage</option>
        <option>Enfant</option>
        <option>Noël</option>
        <option>Pâques</option>
      </select>
    </div>

    <input type="hidden" name="action" value="create_done" />

    <button type="submit" class="btn btn-primary">Valider</button>
    <a class="btn btn-warning mr-3" href="main.ctrl.php?page_type=profil" role="button" aria-pressed="true"><i class="fas fa-user-circle"></i> Page de profil</a>
  </form>
</div>
