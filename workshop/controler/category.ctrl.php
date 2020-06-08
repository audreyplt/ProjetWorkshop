<?php

// CONSTANTS ///////////////////////////////////////////////////////////////////////////////////////////////////////////
define('NB_TEMPLATES_PAGE', 15);

// BODY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$templates = array(); // list of templates to display
$stored_page = null; // the redirect to the corresponding Photoweb page product

if (isset($_GET['category'])) { // check if the URL is correct
  // start filting templates
  $type = null;
  $keywords = array();
  $topics = array();
  $formats = array();
  $sizes = array();
  $rateMin = null;

  if (isset($_POST['search']) && strlen($_POST['search']) > 0) $keywords = explode(' ', $_POST['search']);
  if (isset($_POST['themes']) && $_POST['themes'] != null) $topics = $_POST['themes'];
  if (isset($_POST['rate_min']) && $_POST['rate_min'] != null) $rateMin = $_POST['rate_min'];

  switch ($_GET['category']) {
    case 'photo_books':
      $category_name = 'Livres Photos';
      $type = DAO::ALBUM_TEMPLATE;

      if (isset($_POST['formats']) && $_POST['formats'] != null) $formats = $_POST['formats'];
      if (isset($_POST['sizes']) && $_POST['sizes'] != null) $sizes = $_POST['sizes'];

      $templates = $superManager->getTemplatesFiltered($type, $keywords, $topics, $rateMin, $formats, $sizes);
	    $stored_page = 'https://www.photoweb.fr/livre-photo/listing';
      break;
    case 'objects_and_decor':
      $category_name = 'Objets & Déco';
	    $stored_page = 'https://www.photoweb.fr/deco-maison/listing';
      // TODO
      break;
    case 'wall_decor':
      $category_name = 'Déco murale';
	    $stored_page = 'https://www.photoweb.fr/decoration-murale/listing';
      // TODO
      break;
    case 'greeting_cards':
      $category_name = 'Cartes de voeux';
	    $stored_page = 'https://www.photoweb.fr/produits/faire-part';
      // TODO
      break;
    case 'calendars_and_diaries':
      $category_name = 'Calendriers & Agendas';
	    $stored_page = 'https://www.photoweb.fr/produits/calendrier-agenda-photo';
      // TODO
      break;
    case 'photo_printing':
      $category_name = 'Tirages Photo';
	    $stored_page = 'https://www.photoweb.fr/produits/tirage-photo';
      // TODO
      break;
    default: // error
      header('Location: main.ctrl.php?page_type=error&code_error=404');
      break;
  }
} else { // error
  header('Location: main.ctrl.php?page_type=error');
}
// continuation of filtering of templates
templatePrivatePurge($templates);

$templatesFiltered = array();

foreach ($templates as $template) {
  array_push($templatesFiltered, $template);
}

if (isset($_GET['type'])) {
  switch($_GET['type']) {
    case 'popular':
      // descending sorting by popularity
      usort($templatesFiltered, "cmpTemplatePopularity");
      break;
    case 'recent':
      // sorting: the most recent templates
      usort($templatesFiltered, "cmpTemplatePubDate");
      break;
    default: // error
      header('Location: main.ctrl.php?page_type=error');
      break;
  }
} else {
  // default sorting: popularity
  usort($templatesFiltered, "cmpTemplatePopularity");
}

// pagination
$total_nb_elements = count($templatesFiltered);
$max_num_page = ceil($total_nb_elements / NB_TEMPLATES_PAGE);

if (isset($_GET['page'])) {
  $num_page = $_GET['page'];

  if ($num_page < 1) {
    $num_page = 1;
  } else if ($num_page > $max_num_page) {
    $num_page = $max_num_page;
  }
} else {
  $num_page = 1;
}
$templates = paginator($templatesFiltered, $num_page, NB_TEMPLATES_PAGE);
$tab_subtitle = $category_name;

?>
