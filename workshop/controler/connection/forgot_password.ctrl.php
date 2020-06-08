<?php

if (isset($_POST['email'])) { // if form completed
  $user = $superManager->loginUser($_POST['email']);

  // check if email is valid
  if ($user != null) { // email valid
    $page_element = '../view/recovery_password.view.html';
    $tab_subtitle = 'Récupération du mot de passe';
  } else { // error
    $error_message = 'Adresse e-mail inexistante';
  }
}

?>
