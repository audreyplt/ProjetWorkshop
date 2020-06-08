<!-- MODAL -->
<div class="modal fade" id="<?= isset($prefix) ? $prefix : '' ?>modalProfil<?= $template->getRef() ?>" tabindex="-1" role="dialog" aria-labelledby="modalTemplate" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Informations sur le template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="row align-items-center">
          <!--CAROUSEL-->
          <div class="col-8 text-center">
            <img src="<?= ($template->getPreview() != null) ? $template->getPreview() : '../view/resources/img/templates/template_photo_books.png' ?>" alt="">
          </div>

          <!--ATTRIBUTES-->
          <div class="col-4 border border-secondary rounded bg-dark py-3">
            <div class="text-center text-warning">
              <h4><?= $template->getName() ?></h4>
              <p>Réalisé par : <a href="main.ctrl.php?page_type=profil&profil_id=<?= $template->getUser()->getId() ?>"><?= $template->getUser()->getPseudo() ?></a></p>
            </div>
            <div class="border-top border-bottom border-secondary py-3 pl-1">
              <ul class="list-unstyled mb-0">
                <li class="text-success">Thème : <?= $template->getTopic() ?></li>
                <li class="text-warning">Format : <?= $template->getFormat() ?></li>
                <li class="text-danger">Taille : <?= $template->getSize() ?></li>
                <li class="text-info">
                  <p class="mb-0">
                    Tags :
                    <?php foreach ($template->getTags() as $tag) { ?>
                      <span class="badge badge-info"><?= $tag ?></span>
                    <?php } ?>
                  </p>
                </li>
              </ul>
            </div>
            <div class="row align-items-center mt-3 mb-2 mx-0 pl-1">
              <p class="text-warning pr-2 mb-0">Note :</p>
              <span class="text-secondary"><?= getStars($template) ?> (<?= count($template->getRates()) ?> notes)</span>
            </div>
            <!--COMMENTARIES-->
            <div class="overflow-auto" style="height:350px;">
              <?php foreach ($template->getCommentaries() as $commentary): ?>
                <div class="bg-light mb-3 mr-1 p-2 border border-secondary rounded">
                  <h6 class="border-bottom border-secondary pb-2">De : <a href="main.ctrl.php?page_type=profil&profil_id=<?= $superManager->getUser($commentary->getUser())->getId() ?>"><?= $superManager->getUser($commentary->getUser())->getPseudo() ?></a></h6>
                  <p class="mb-0 pl-1"><?= $commentary->getText() ?></p>

                  <div class="container mt-2">
                    <div class="row mx-0">
                      <small class="mr-auto">Le <?= $commentary->getPubDate() ?></small>
                      <small><a href="">Signaler le commentaire</a></small>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
