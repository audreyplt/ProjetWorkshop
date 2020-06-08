<?php

if (isset($_GET['code_error'])) {
  switch ($_GET['code_error']) {
    case 404:
      $error_title = ERROR_TITLE_PAGE_NOT_FOUND;
      $error_message = ERROR_MESSAGE_PAGE_NOT_FOUND;
      $page_elements = array('../view/error.view.php');
      $tab_subtitle = 'Erreur';
      require_once('display.ctrl.php');
      break;
    default:
      $error_title = ERROR_TITLE_DEFAULT;
      $error_message = ERROR_MESSAGE_DEFAULT;
      $page_elements = array('../view/error.view.php');
      $tab_subtitle = 'Erreur';
      require_once('display.ctrl.php');
      break;
  }
} else {
  $error_title = ERROR_TITLE_DEFAULT;
  $error_message = ERROR_MESSAGE_DEFAULT;
  $page_elements = array('../view/error.view.php');
  $tab_subtitle = 'Erreur';
  require_once('display.ctrl.php');
}

?>
