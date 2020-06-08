<?php

if (isset($_GET['profil_id'])) { // consultation of the "public" profil
  $user = $superManager->getUser($_GET['profil_id']);

  // check if the user ID is correct
  if ($user == null) { // error, wrong user ID
    header('Location: main.ctrl.php?page_type=error&code_error=404');
  }
  // user ID valid
  // display of the "public" profil page
} else if (isset($_SESSION['id'])) { // consultation of the "private" profil
  if (isset($_POST['action'])) { // if an action has to be realize
    if ($_POST['action'] == 'edit_profil') {
      $page_element = '../view/profil/edit_profil.view.php';
      $tab_subtitle = 'Édition du profil';
    } else if ($_POST['action'] == 'edit_profil_done') {
      $user = $superManager->getUser($_SESSION['id']);
      $user->setPseudo($_POST['u_pseudo']);
      $user->setEmail($_POST['u_email']);
      $user->setPassword($_POST['u_password']);
      $user->setCity($_POST['u_city']);
      $user->setCountry($_POST['u_country']);
      $user->setResume($_POST['u_resume']);
      $superManager->updateUser($user);

      $edit_message = 'Les informations de votre compte ont été mises à jour';
    } else if ($_POST['action'] == 'create') {
      $page_element = '../view/templates/create_template.view.php';
      $tab_subtitle = 'Création de template';
    } else if ($_POST['action'] == 'create_done') {
      $datas = array(
        't_user' => $superManager->getUser($_SESSION['id']),
        't_name' => $_POST['t_name'],
        't_description' => $_POST['t_description'],
        't_public' => 0,
        'at_size' => $_POST['t_size'],
        'at_format' => $_POST['t_format'],
        't_topic' => $_POST['t_topic']
      );
      $template = new AlbumTemplate($datas);
      $superManager->addTemplate($template);

      $superManager->updateTemplate($template);

      $edit_message = 'Le template ' . $template->getName() . ' a été créé avec succès';
    } else {
      $template = $superManager->getTemplate($_POST['template_ref'], DAO::ALBUM_TEMPLATE);

      if ($_POST['action'] == 'submit') { // is a submit request of the specified template ?
        $template->setPublic(true);
        $superManager->updateTemplate($template);

        $submit_message = 'Le template ' . $template->getName() . ' a bien été publié';
      } else if ($_POST['action'] == 'edit') { // an editing ?
        $page_element = '../view/templates/edit_template.view.php';
        $tab_subtitle = 'Édition de template';
      } else if ($_POST['action'] == 'edit_done') { // or a feed back of the editing template ?
        $template->setName($_POST['t_name']);
        $template->setDescription($_POST['t_description']);
        $superManager->updateTemplate($template);

        $edit_message = 'Le template ' . $template->getName() . ' a bien été modifié';
      } else {
        $edit_message = 'test';
      }
    }
  }
  $user = $superManager->getUser($_SESSION['id']);
  // display of the "private" profil page
} else { // error
  header('Location: main.ctrl.php?page_type=error');
}

?>
