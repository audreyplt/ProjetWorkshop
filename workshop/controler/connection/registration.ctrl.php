<?php

if (!isset($_SESSION['id'])) { // if not connected
  if (isset($_POST['email'])) { // if form completed
    $emailParts = explode('@', $_POST['email']);
    $login = $emailParts[0];

    if ($user = $superManager->loginUser($_POST['email'])) {
      // email already used
      $error_message = 'Cette adresse e-mail est déjà utilisée';
    } else {
      // creation of the user
      $datas = array (
        'u_login' => $login,
        'u_email' => $_POST['email'],
        'u_password' => $_POST['password'],
        'u_first_name' => $_POST['first_name'],
        'u_last_name' => $_POST['last_name'],
        'u_pseudo' => $login,
      );
      $user = new User($datas);
      // add to the database
      $id = $superManager->addUser($user);
      // revovery of the user (to get the user ID)
      $user = $superManager->getUser($id);

      $_SESSION['id'] = $user->getId();
      // display of the success registration page
      $page_element = '../view/connection/registration_success.view.html';
    }
  }
} else { // already connected
  // redirect to the "private" profil page
  header('Location: main.ctrl.php?page_type=profil');
}

?>
