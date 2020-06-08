<!--BANNER-->
<div class="container mb-3">
  <div class="row bg-secondary justify-content-between mx-0 p-3 rounded-bottom shadow">
    <div class="col row mx-0 px-0">

      <!--AVATAR-->
      <div class="px-0">
        <img class="border border-dark shadow" src="<?= ($user->getAvatar() != null) ? $user->getAvatar() : '../view/resources/img/avatar/avatar.jpg' ?>" alt="avatar-184x184">
      </div>

      <!--PSEUDO - LOCALISATION - RESUME-->
      <div class="col ml-4">
        <h4><?= $user->getPseudo() ?> <img src="../view/resources/img/flags/<?= $user->getCountry() ?>.png" alt="" width="20" height="20" /></h4>
        <p class="mb-0"><?= $user->getFirstName() ?> <?= $user->getLastName() ?> - <?= $user->getCity() ?>, <?= $user->getCountry() ?></p>

        <div class="p-2">
          <fieldset class="border border-dark px-3" style="border-width: 2px !important;">
            <legend class="scheduler-border pl-1 pr-2 w-auto">Description</legend>
            <p class="text-justify text-wrap"><?= strlen($user->getResume()) > 0 ? $user->getResume() : 'Aucune information disponible.' ?></p>
          </fieldset>
        </div>
      </div>
    </div>

    <!--LEVEL - BUTTONS-->
    <div>
      <div class="container">
        <div class="row justify-content-end mx-0">
          <div>
            <div class="row justify-content-center">
              <h4 class="mb-3">Niveau <?= count($superManager->getUserBadges($user)) ?></h4>
            </div>
            <div class="row justify-content-center">
              <p class="p-2 bg-light rounded text-center">
                Pas de badge d'affiché.<br />
                <?php if (!isset($_GET['profil_id'])): ?>
                  <a href="#">Choisir un badge</a>
                <?php endif; ?>
              </p>
            </div>
            <div class="row justify-content-center align-self-end">
              <?php if (!isset($_GET['profil_id'])): ?>
                <form action="main.ctrl.php?page_type=profil" method="post">
                  <input type="hidden" name="action" value="edit_profil" />
                  <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Modifier le profil</button>
                </form>
              <?php else: ?>
                <button class="btn btn-warning"><i class="fas fa-exclamation-circle"></i> Signaler le profil</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (isset($submit_message)): ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 alert alert-success text-center" role="alert">
        <?= $submit_message ?>
      </div>
    </div>
  </div>
<?php elseif (isset($edit_message)): ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 alert alert-info text-center" role="alert">
        <?= $edit_message ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<!--BODY-->
<div class="container rounded-bottom border shadow" style="background-color: #EFEFEF;">
  <div class="row mx-0">
    <div class="col-9">
      <div class="tab-content" id="v-pills-tabContent">

        <!--INVENTORY-->
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <h5 class="m-3">Inventaire</h5>

          <!-- TEMPLATES -->
          <?php if (count($user->getTemplates()) > 0): ?>
            <?php foreach ($user->getTemplates() as $template): ?>
              <div class="card mb-3 shadow-sm p-2">
                <div class="row mx-0">
                  <div class="col-lg-4 mt-1">
                    <img src="<?= ($template->getPreview() != null) ? $template->getPreview() : '../view/resources/img/templates/template_photo_books.png' ?>" class="card-img-top" alt="template_albumPhoto" width="250" height="200">
                  </div>
                  <div class="col-lg-8 row card-body">
                    <h5 class="col-12 align-self-start card-title pl-0">
                      <?= $template->getName() ?>
                      <?php if ($template->isPublic()): ?>
                        <span class="badge badge-success ml-1">Public</span>
                      <?php else: ?>
                        <span class="badge badge-danger ml-1">Privé</span>
                      <?php endif; ?>
                    </h5>

                    <p class="col-12 card-text pl-0"><?= $template->getDescription() ?></p>

                    <div class="col-12 align-self-end mx-0">
                      <div class="row">
                        <p class="card-text"><small class="text-muted">Date de publication : <?= $template->getPubDate() ?></small></p>
                      </div>
                      <div class="row justify-content-between align-items-center">
                        <small class="text-muted">
                          <?= getStars($template) ?>
                          <span class="ml-2"> - <?= count($template->getRates()) ?> avis</span>
                        </small>
                        <form action="main.ctrl.php?page_type=profil" method="post">
                          <input type="hidden" id="action<?= $template->getRef() ?>" name="action" value="" />
                          <input type="hidden" name="template_ref" value="<?= $template->getRef() ?>" />

                          <?php if (!isset($_GET['profil_id'])): ?>
                            <button type="submit" class="btn btn-sm btn-primary" onclick="inputValue<?= $template->getRef() ?>('edit')"><i class="far fa-edit"></i> Modifier</button>
                            <?php if (!$template->isPublic()): ?>
                              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_submit_<?= $template->getRef() ?>">
                                <i class="fas fa-upload"></i> Publier
                              </button>

                              <!-- Modal -->
                              <div class="modal fade" id="modal_submit_<?= $template->getRef() ?>" tabindex="-1" role="dialog" aria-labelledby="modal_submit_label_<?= $template->getRef() ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modal_submit_label_<?= $template->getRef() ?>">Confirmation</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>En publiant votre template, vous acceptez que des personnes tiers puissent s'en servir pour la réalisation et l'impression de leur propre produit sur Photoweb.</p>
                                      <p>Cliquez de nouveau sur le bouton "Publier" pour confirmer votre choix.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Refuser</button>
                                      <button type="submit" class="btn btn-sm btn-success" onclick="inputValue<?= $template->getRef() ?>('submit')"><i class="fas fa-upload"></i> Publier</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php endif; ?>
                          <?php endif; ?>
                          <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#modalProfil<?= $template->getRef() ?>"><i class="fas fa-eye"></i> Aperçu</button>
                          <?php include('../view/templates/template_modal.view.php') ?>
                        </form>

                        <script type="text/javascript">
                          function inputValue<?= $template->getRef() ?>(action) {
                            document.getElementById('action<?= $template->getRef() ?>').value=action;
                          }
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="row justify-content-center mb-2">
              <h3 class="text-center">Aucun template</h3>
            </div>
            <div class="row justify-content-center">
              <button type="button" class="btn btn-sm btn-outline-primary">Créer un template</button>
            </div>
          <?php endif; ?>
        </div>

        <!--BADGES-->
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <h5 class="m-3">Badges</h5>

          <?php foreach ($superManager->getUserBadges($user) as $badge): ?>
            <div class="card mb-3 p-3">
              <div class="row mx-0">
                <div class="col-lg-3">
                  <div class="row justify-content-center align-items-center mx-0">
                    <img src="../view/resources/img/badges/badge-icon.png" class="img-fluid" alt="template_albumPhoto" width="100" height="100">
                  </div>
                </div>
                <div class="col-lg-8 align-self-center card-body p-1">
                  <h5 class="card-title mb-2"><?= $badge->getName() ?></h5>
                  <p class="card-text mb-2"><?= $badge->getDescription() ?></p>
                  <p class="card-text"><small class="text-muted">Obtenu le : <?= $badge->getDateObtained() ?></small></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <?php foreach ($superManager->getBadgesNonObtained($user) as $badge): ?>
            <div class="card mb-3 p-3">
              <div class="row mx-0">
                <div class="col-lg-3">
                  <div class="row justify-content-center align-items-center mx-0">
                    <img src="../view/resources/img/badges/badge-icon-none.png" class="img-fluid" alt="template_albumPhoto" width="100" height="100">
                  </div>
                </div>
                <div class="col-lg-8 align-self-center card-body p-1">
                  <h5 class="card-title mb-2"><?= $badge->getName() ?></h5>
                  <p class="card-text mb-2"><?= $badge->getDescription() ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="col-3">
      <!--MENU TABS-->
      <div class="nav flex-column nav-pills mt-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Inventaire</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Badges</a>
      </div>
      <div class="container mt-3 px-0">
        <form class="row justify-content-center mx-0" action="main.ctrl.php?page_type=profil" method="post">
          <input type="hidden" id="action" name="action" value="create" />
          <button type="submit" class="btn btn-success"><i class="fas fa-plus-square"></i> Créer un template</button>
        </form>
      </div>
    </div>
  </div>
</div>
