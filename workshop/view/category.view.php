<?php

function generatePath() : string {
  $path = 'main.ctrl.php?';
  $path .= 'page_type=' . $_GET['page_type'];
  $path .= '&category=' . $_GET['category'];

  if (isset($_GET['type'])) {
    $path .= '&type=' . $_GET['type'];
  }
  return $path;
}

function displayTemplates() {
  global $templates;
  global $superManager;
  global $total_nb_elements;
  global $num_page;
  global $max_num_page;

  if (count($templates) > 0) { ?>
    <div class="row mt-3">
      <?php foreach ($templates as $template): ?>
        <div class="col-md-4">
          <div class="card mb-4 box-shadow shadow-sm">
            <img class="card-img-top" src="<?= ($template->getPreview() != null) ? $template->getPreview() : '../view/resources/img/templates/template_photo_books.png' ?>" alt="template_albumPhoto" />
            <div class="card-body">
              <h5 class="card-title"><?= $template->getName() ?></h5>
              <p class="card-text"><?= $template->getDescription() ?></p>
              <small class="text-muted">
                <?= getStars($template) ?>
                - <?= count($template->getRates()) ?> avis <!-- A compléter : <a> -->
                </small>
                <div class="d-flex justify-content-between align-items-center mt-1">
                  <small class="text-muted">par <a href="main.ctrl.php?page_type=profil&profil_id=<?= $template->getUser()->getId() ?>"><?= $template->getUser()->getPseudo() ?></a> - Le <?= $template->getPubDate() ?></small>
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#modalProfil<?= $template->getRef() ?>"><i class="fas fa-eye"></i> Aperçu</button>
                  <?php include('../view/templates/template_modal.view.php') ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        if ($total_nb_elements > NB_TEMPLATES_PAGE): ?>
        <div class="col-12">
          <?php include('../view/elements/pagination.view.php'); ?>
        </div>
        <?php endif; ?>
    </div>
  <?php } else { ?>
    <div class="row justify-content-center">
      <h3 class="my-5">Aucun template à afficher</h3>
    </div>
  <?php }
}

?>

<div class="container pt-4 rounded" style="background-color: #EFEFEF;">
  <div class="row justify-content-center mb-3">
    <h3>WorkShop - <?= $category_name ?></h3>
  </div>
  <img class="img-fluid shadow rounded-top" src="../view/resources/img/templates/banner.png" alt="WorkShop" width="1140" height="174" />

  <!-- FILTERING -->
  <div class="accordion shadow-sm" id="accordionFilter">
    <div class="card rounded-bottom text-white bg-dark">
      <form class="mb-0" action="<?= generatePath() ?>" method="post">
        <div class="card-header container" id="headingFilter">
          <div class="row justify-content-center align-items-center mx-0">
            <h5 class="col-12 col-sm-auto mb-sm-0 text-center mr-auto">Filtrage des templates</h5>

            <!-- SEARCH BAR -->
            <div class="col-12 col-sm-5 col-md-7 col-lg-8 col-xl-9">
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Recherche par nom, tag, ..." aria-label="Recipient's username" aria-describedby="button-addon2" />
                <div class="input-group-append">
                  <button class="col-lg-12 btn btn-light border-left" type="submit" id="button-addon"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>

            <button class="btn text-white collapsed col-12 col-sm-auto" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
              <i class="fas fa-caret-down"></i>
            </button>
          </div>
        </div>

        <!-- CARD BODY -->
        <!--<div id="collapseFilter" class="collapse--><?//= hasFilter() ? ' show' : '' ?><!--" aria-labelledby="headingFilter" data-parent="#accordionFilter">-->
        <div id="collapseFilter" class="collapse <?= (isset($_POST) && $_POST != null) ? ' show' : '' ?>" aria-labelledby="headingFilter" data-parent="#accordionFilter">
          <div class="card-body pb-2">
            <div class="container">
              <div class="row mb-3">
                <?php if (isset($_POST['search']) && strlen($_POST['search']) > 0): ?>
                  <span class="ml-3 text-light">
                    Recherche actuelle :
                    <?php
                    $words = explode (' ', $_POST['search']);
                    foreach ($words as $word) { ?>
                      <span class="badge badge-info"><?= $word ?></span>
                    <?php } ?>
                  </span>
                <?php endif; ?>
              </div>

              <div class="row mb-3">
                <!--THEMES-->
                <div class="col-lg-4 text-danger m-auto">
                  <div class="container">
                    <div class="row justify-content-center">
                      <div>
                        <p>Thème(s)</p>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox1" name="themes[]" value="Testing" <?= (isset($_POST['themes']) && in_array('Testing', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox1">Testing</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox1" name="themes[]" value="voyage" <?= (isset($_POST['themes']) && in_array('voyage', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox1">Voyage</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox2" name="themes[]" value="vacances" <?= (isset($_POST['themes']) && in_array('vacances', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox2">Vacances</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox3" name="themes[]" value="mariage" <?= (isset($_POST['themes']) && in_array('mariage', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox3">Mariage</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox4" name="themes[]" value="enfant" <?= (isset($_POST['themes']) && in_array('enfant', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox4">Enfant</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox5" name="themes[]" value="noel" <?= (isset($_POST['themes']) && in_array('noel', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox5">Noël</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="topicCheckbox6" name="themes[]" value="paques" <?= (isset($_POST['themes']) && in_array('paques', $_POST['themes'])) ? 'checked' : '' ?> />
                          <label class="form-check-label" for="topicCheckbox6">Pâques</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php if ($_GET['category'] == 'photo_books'): ?>
                  <!--FORMAT-->
                  <div class="col-lg-4 text-info">
                    <div class="container">
                      <div class="row justify-content-center">
                        <div>
                          <p>Format(s)</p>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="formatCheckbox1" name="formats[]" value="portrait" <?= (isset($_POST['formats']) && in_array('portrait', $_POST['formats'])) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="formatCheckbox1">Portrait</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="formatCheckbox2" name="formats[]" value="carré" <?= (isset($_POST['formats']) && in_array('carré', $_POST['formats'])) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="formatCheckbox2">Carré</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="formatCheckbox3" name="formats[]" value="paysage" <?= (isset($_POST['formats']) && in_array('paysage', $_POST['formats'])) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="formatCheckbox3">Paysage</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--SIZE-->
                  <div class="col-lg-4 text-success">
                    <div class="container">
                      <div class="row justify-content-center">
                        <div>
                          <p>Taille(s)</p>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sizeCheckbox1" name="sizes[]" value="S" <?= (isset($_POST['sizes']) && in_array('S', $_POST['sizes'])) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="sizeCheckbox1">S</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sizeCheckbox2" name="sizes[]" value="M" <?= (isset($_POST['sizes']) && in_array('M', $_POST['sizes'])) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="sizeCheckbox2">M</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sizeCheckbox3" name="sizes[]" value="L" <?= (isset($_POST['sizes']) && in_array('L', $_POST['sizes'])) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="sizeCheckbox3">L</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>

              <!--RATE-->
              <div class="form-inline justify-content-between text-warning my-2">
                <div class="row align-items-center">
                  <p class="mb-0 mr-2 ml-3">Note minimale : </p>
                  <div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <div id="stars" class="star-rating"><s><s><s><s><s></s></s></s></s></s></div>
                  </div>
                </div>
                <input id="input-nbStar" type="hidden" name="rate_min" value="<?= isset($_POST['rate_min']) ? $_POST['rate_min'] : '' ?>" />

                <style>
                  .star-rating s:hover,
                  .star-rating s.active {
                    color: gold;
                  }
                  .star-rating s {
                    color: black;
                    font-size: 25px;
                    cursor: default;
                    text-decoration: none;
                    line-height: 50px;
                  }
                  .star-rating {
                    padding: 2px;
                  }
                  .star-rating s.rated:before,
                  .star-rating s.active:before {
                    content: "\2605";
                  }
                  .star-rating s:before {
                    content: "\2606";
                  }
                </style>

                <script>
                    let activeNbStar = document.getElementById('input-nbStar').value; // problème si 0
                    $(function() {
                        $("div.star-rating > s").on("click", function(e) {

                            // remove all active classes first, needed if user clicks multiple times
                            $(this).closest('div').find('.active').removeClass('active');

                            $(e.target).parentsUntil("div").addClass('active'); // all elements up from the clicked one excluding self
                            $(e.target).addClass('active');  // the element user has clicked on
                            activeNbStar = $(this).closest('div').find('.active').length;
                            document.getElementById('input-nbStar').value = activeNbStar;
                        });
                    });

                    function worker(star,i) {
                        if (i > 0) {
                            star.childNodes[0].classList.add('active');
                            i--;
                            worker(star.childNodes[0],i);
                        }
                    }
                    window.onload = function load() {
                      let stars = document.getElementById('stars');
                      let i = document.getElementById('input-nbStar').value;
                          worker(stars,i);
                  }
                </script>

                <div>
                  <a href="main.ctrl.php?page_type=category&category=<?= $_GET['category'] ?>&action=clear<?= (isset($_GET['type']) ? '&type='.$_GET['type'] : '') ?>" class="btn btn-danger active" role="button" aria-pressed="true">Supprimer les filtres</a>
                  <button type="submit" class="btn btn-primary">Appliquer</button>
                </div>
              </div>
            </div>
            <input type="hidden" name="source" value="category" />
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row justify-content-center align-items-center mt-3 mx-0">
    <div class="col-12 mb-3 mb-sm-0 col-sm-auto mr-auto">
      <nav class="mb-sm-0" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="main.ctrl.php">WorkShop</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?= $category_name ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 col-sm-auto text-center">
      <a href="<?= (isset($stored_page) && $stored_page != null) ? $stored_page : '#' ?>" class="btn btn-outline-primary"><i class="fas fa-shopping-cart"></i> Page du magasin</a>
    </div>
  </div>

  <!-- TEMPLATES -->
  <div class="mt-3">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link <?= (!isset($_GET['type']) || $_GET['type'] == 'popular') ? 'active' : '' ?>" href="main.ctrl.php?page_type=category&category=<?= $_GET['category'] ?>&type=popular">Les plus populaires</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (isset($_GET['type']) && $_GET['type'] == 'recent') ? 'active' : '' ?>" href="main.ctrl.php?page_type=category&category=<?= $_GET['category'] ?>&type=recent">Les plus récents</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="main.ctrl.php?page_type=category&category=<?= $_GET['category'] ?>&type=usefull">Les plus utilisés</a> <!-- A compléter -->
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="populaires" role="tabpanel" aria-labelledby="home-tab">
        <?= displayTemplates() ?>
      </div>
      <div class="tab-pane fade" id="recents" role="tabpanel" aria-labelledby="contact-tab">
        <?= displayTemplates() ?>
      </div>
      <div class="tab-pane fade" id="utilises" role="tabpanel" aria-labelledby="profile-tab">
        <?= displayTemplates() ?>
      </div>
    </div>
  </div>
</div>
