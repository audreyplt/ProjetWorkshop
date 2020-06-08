<div class="container mt-4">
  <h4 class="row justify-content-center mb-3">Modification du template : <?= $template->getName() ?></h4>
  <div class="row justify-content-center align-items-start">
    <img src="<?= ($template->getPreview() != null) ? $template->getPreview() : '../view/resources/img/templates/template_photo_books.png' ?>" class="img-fluid" alt="template_albumPhoto" width="250" height="200">
  </div>

  <?php if (isset($error_message)): ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $error_message; ?>
    </div>
  <?php endif; ?>

  <form action="main.ctrl.php?page_type=profil" method="post">
    <!-- NAME -->
    <div class="form-group">
      <label for="t_name">Nom du template</label>
      <input type="text" class="form-control" name="t_name" id="t_name" value="<?= $template->getName() ?>" required />
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group">
      <label for="t_description">Description</label>
      <textarea class="form-control" name="t_description" id="t_description" required><?= $template->getDescription() ?></textarea>
    </div>

    <input type="hidden" name="action" value="edit_done" />
    <input type="hidden" name="template_ref" value="<?= $template->getRef() ?>" />

    <button type="submit" class="btn btn-primary">Valider</button>
    <a class="btn btn-warning mr-3" href="main.ctrl.php?page_type=profil" role="button" aria-pressed="true"><i class="fas fa-user-circle"></i> Page de profil</a>
  </form>
</div>
