<!--JUMBOTRON-->
<section class="jumbotron" style="background-image: url('../view/resources/img/home_jumbotron.png');">
  <div class="container">
    <h1 class="jumbotron-heading">Créer, trouver et télécharger du contenu pour vos créations photo</h1>
    <p class="lead">Parcourez les pages suivantes pour trouver du contenu créé par les utilisateurs pour vos créations photo.</p>
  </div>
</section>

<!--CATEGORIES-->
<div class="container card rounded shadow-sm px-0">
  <h5 class="card-header mb-0"><strong>WORKSHOP - CATEGORIES</strong></h5>
  <div class="card-body">
    <div class="container px-0">
      <div class="row mx-0">
        <div class="col-md-4">
          <a href="main.ctrl.php?page_type=category&category=photo_books">
            <div class="card mb-4 shadow-sm">
              <img class="bd-placeholder-img card-img-top shadow-sm" width="100%" height="225" src="../view/resources/img/categories/photo_books.png" alt="albums photo">
              <div class="card-body p-2">
                <p class="card-text text-center"><strong>ALBUMS PHOTO</strong></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="main.ctrl.php?page_type=category&category=objects_and_decor">
            <div class="card mb-4 shadow-sm">
              <img class="bd-placeholder-img card-img-top shadow-sm" width="100%" height="225" src="../view/resources/img/categories/objects_and_decor.png" alt="objets & décos">
              <div class="card-body p-2">
                <p class="card-text text-center"><strong>OBJETS & DECOS</strong></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="main.ctrl.php?page_type=category&category=wall_decor">
            <div class="card mb-4 shadow-sm">
              <img class="bd-placeholder-img card-img-top shadow-sm" width="100%" height="225" src="../view/resources/img/categories/wall_decor.png" alt="déco murale">
              <div class="card-body p-2">
                <p class="card-text text-center"><strong>DÉCO MURALE</strong></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="main.ctrl.php?page_type=category&category=greeting_cards">
            <div class="card mb-4 shadow-sm">
              <img class="bd-placeholder-img card-img-top shadow-sm" width="100%" height="225" src="../view/resources/img/categories/greeting_cards.png" alt="cartes & faire-parts">
              <div class="card-body p-2">
                <p class="card-text text-center"><strong>CARTES DE VOEUX</strong></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="main.ctrl.php?page_type=category&category=calendars_and_diaries">
            <div class="card mb-4 shadow-sm">
              <img class="bd-placeholder-img card-img-top shadow-sm" width="100%" height="225" src="../view/resources/img/categories/calendars_and_diaries.png" alt="calendriers & agendas">
              <div class="card-body p-2">
                <p class="card-text text-center"><strong>CALENDRIERS & AGENDAS</strong></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="main.ctrl.php?page_type=category&category=photo_printing">
            <div class="card mb-4 shadow-sm">
              <img class="bd-placeholder-img card-img-top shadow-sm" width="100%" height="225" src="../view/resources/img/categories/photo_printing.png" alt="tirage photo">
              <div class="card-body p-2">
                <p class="card-text text-center"><strong>TIRAGE PHOTO</strong></p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!--MOST POPULAR TEMPLATES-->
<div class="container shadow-sm px-0">
  <nav class="navbar navbar-expand-lg navbar-light bg-light border rounded-top mt-4">
    <div class="collapse navbar-collapse">
      <h5 class="mb-0"><strong>WORKSHOP - LES PLUS POPULAIRES</strong></h5>
    </div>
    <div class="my-2 my-lg-0">
      <a href="#popular" role="button" data-slide="prev">
        <button class="btn btn-info">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
      </a>
      <a class="" href="#popular" role="button" data-slide="next">
        <button class="btn btn-info">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
      </a>
    </div>
  </nav>

  <div id="popular" class="carousel slide" data-ride="carousel">
    <?php if (isset($templatesPopularity) && count($templatesPopularity) > 0): ?>
      <div class="carousel-inner">
        <?php foreach ($templatesPopularity as $key => $template): ?>
          <div class="carousel-item <?= ($key == 0) ? 'active' : '' ?>">
            <div class="container border border-top-0 rounded-bottom">
              <div class="row mx-0">
                <div class="col-auto container px-0">
                  <div class="row justify-content-center align-items-center mx-2 mt-2">
                    <img src="<?= ($template->getPreview() != null) ? $template->getPreview() : '../view/resources/img/templates/template_photo_books.png' ?>" class="img-fluid" alt="template_albumPhoto" width="250" height="200">
                  </div>
                </div>

                <div class="col-auto row card-body">
                  <h5 class="col-12 mx-0 card-title"><?= $template->getName() ?></h5>
                  <p class="col-12 mx-0 card-text"><?= $template->getDescription() ?></p>

                  <div class="col-12 align-self-end mx-0">
                    <div class="container px-0">
                      <div class="row mx-0">
                        <p class="card-text"><small class="text-muted">Date de publication : <?= $template->getPubDate() ?></small></p>
                      </div>
                      <div class="row justify-content-between align-items-center mx-0">
                        <small class="text-muted">
                          <?= getStars($template) ?>
                          <span class="ml-2"> - <?= count($template->getRates()) ?> avis</span>
                        </small>
                        <?php $prefix = 'popular' ?>
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#<?= $prefix ?>modalProfil<?= $template->getRef() ?>"><i class="fas fa-eye"></i> Aperçu</button>
                        <?php include('../view/templates/template_modal.view.php') ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<!--LATEST TEMPLATES-->
<div class="container shadow-sm px-0">
  <nav class="navbar navbar-expand-lg navbar-light bg-light border rounded-top mt-4">
    <div class="collapse navbar-collapse">
      <h5 class="mb-0"><strong>WORKSHOP - LES PLUS RECENTS</strong></h5>
    </div>

    <div class="my-2 my-lg-0">
      <a class="btn btn-info" href="#latest" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></a>
      <a class="btn btn-info" href="#latest" role="button" data-slide="prev"><span class="carousel-control-next-icon" aria-hidden="true"></span></a>
    </div>
  </nav>

  <div id="latest" class="carousel slide" data-ride="carousel">
    <?php if (isset($templatesPubDate) && count($templatesPubDate) > 0): ?>
      <div class="carousel-inner">
        <?php foreach ($templatesPubDate as $key => $template): ?>
          <div class="carousel-item<?= ($key == 0) ? ' active' : '' ?>">
            <div class="container border border-top-0 rounded-bottom">
              <div class="row mx-0">
                <div class="col-auto container px-0">
                  <div class="row justify-content-center align-items-center mx-2 mt-2">
                    <img src="<?= ($template->getPreview() != null) ? $template->getPreview() : '../view/resources/img/templates/template_photo_books.png' ?>" class="img-fluid" alt="template_albumPhoto" width="250" height="200">
                  </div>
                </div>

                <div class="col-auto row card-body">
                  <h5 class="col-12 mx-0 card-title"><?= $template->getName() ?></h5>
                  <p class="col-12 mx-0 card-text text-wrap"><?= $template->getDescription() ?></p>

                  <div class="col-12 align-self-end mx-0">
                    <div class="container px-0">
                      <div class="row mx-0">
                        <p class="card-text"><small class="text-muted">Date de publication : <?= $template->getPubDate() ?></small></p>
                      </div>
                      <div class="row justify-content-between align-items-center mx-0">
                        <small class="text-muted">
                          <?= getStars($template) ?>
                          <span class="ml-2"> - <?= count($template->getRates()) ?> avis</span>
                        </small>
                        <?php $prefix = 'latest' ?>
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#<?= $prefix ?>modalProfil<?= $template->getRef() ?>"><i class="fas fa-eye"></i> Aperçu</button>
                        <?php include('../view/templates/template_modal.view.php'); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
