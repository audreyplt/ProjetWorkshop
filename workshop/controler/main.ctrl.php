<?php

// RESOURCES CALL //////////////////////////////////////////////////////////////////////////////////////////////////////
require_once("../model/managers/SuperManager.class.php");
require_once('utils/utils.ctrl.php');

// CONSTANTS ///////////////////////////////////////////////////////////////////////////////////////////////////////////
define('ERROR_TITLE_PAGE_NOT_FOUND', 'Erreur 404');
define('ERROR_MESSAGE_PAGE_NOT_FOUND', 'La page est introuvable.');
define('ERROR_TITLE_DEFAULT', 'Erreur');
define('ERROR_MESSAGE_DEFAULT', 'Un problème est survenu.');

// SESSION MANAGEMENT //////////////////////////////////////////////////////////////////////////////////////////////////
session_start();

// BODY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$superManager = new SuperManager();

if (isset($_GET['page_type'])) {
  switch ($_GET['page_type']) {
    case 'home':
      $page_element = '../view/home.view.php';
      $tab_subtitle = 'Accueil';
      require_once('home.ctrl.php');
      break;
    case 'connection':
      $page_element = '../view/connection/connection.view.php';
      $tab_subtitle = 'Connexion';
      require_once('connection/connection.ctrl.php');
      break;
    case 'registration':
      $page_element = '../view/connection/registration.view.php';
      $tab_subtitle = 'Inscription';
      require_once('connection/registration.ctrl.php');
      break;
    case 'disconnection':
      $page_element = '../view/connection/disconnection.view.php';
      $tab_subtitle = 'Déconnexion';
      require_once('connection/disconnection.ctrl.php');
      break;
    case 'forgot_password':
      $page_element = '../view/connection/forgot_password.view.php';
      $tab_subtitle = 'Mot de passe oublié';
      require_once('connection/forgot_password.ctrl.php');
      break;
    case 'category':
      $page_element = '../view/category.view.php';
      $tab_subtitle = 'Catégorie';
      require_once('category.ctrl.php');
      break;
    case 'profil':
      $page_element = '../view/profil.view.php';
      $tab_subtitle = 'Profil';
      require_once('profil.ctrl.php');
      break;
    case 'test': // tests
      $page_element = '../view/support.view.php';
      break;
    default:
      $page_element = '../view/elements/error.view.php';
      $tab_subtitle = 'Erreur';
      require_once('utils/error.ctrl.php');
      break;
  }
} else {
  $page_element = '../view/home.view.php';
  $tab_subtitle = 'Accueil';
  require_once('home.ctrl.php'); // the default page
}
require_once('display.ctrl.php'); // display of the page

?>
