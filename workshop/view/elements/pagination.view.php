<nav class="navbar navbar-expand">
  <ul class="pagination mx-auto">
    <li class="page-item<?= $num_page <= 1 ? ' disabled' : '' ?>">
      <a class="page-link" href="<?= generatePath() ?>&page=<?= $num_page - 1 ?>" tabindex="-1"><i class="fas fa-arrow-left"></i></a>
    </li>
    <?php if ($num_page > 2): ?>
      <li class="page-item">
        <a class="page-link" href="<?= generatePath() ?>&page=1">1</a>
      </li>
      <li class="page-item">
        <a class="page-link">..</a>
      </li>
    <?php endif; ?>
    <?php if ($num_page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="<?= generatePath() ?>&page=<?= $num_page - 1 ?>"><?= $num_page - 1 ?></a>
      </li>
    <?php endif; ?>
    <li class="page-item active">
      <a class="page-link" href=""><?= $num_page ?></a>
    </li>
    <?php if ($num_page < $max_num_page): ?>
      <li class="page-item">
        <a class="page-link" href="<?= generatePath() ?>&page=<?= $num_page + 1 ?>"><?= $max_num_page ?></a>
      </li>
    <?php endif; ?>
    <?php if ($num_page < $max_num_page - 1): ?>
      <li class="page-item">
        <a class="page-link">..</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="<?= generatePath() ?>&page=<?= $max_num_page ?>"><?= $max_num_page ?></a>
      </li>
    <?php endif; ?>
    <li class="page-item<?= $num_page >= $max_num_page ? ' disabled' : '' ?>">
      <a class="page-link" href="<?= generatePath() ?>&page=<?= $num_page + 1 ?>"><i class="fas fa-arrow-right"></i></a>
    </li>
  </ul>
</nav>
