<?php

if (isset($_SESSION['id'])) { // if connected, redirect to the "private" profil page
  header('Location: main.ctrl.php?page_type=profil');
} else { // connection request
  if (isset($_POST['login'])) { // if form completed
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user = $superManager->loginUser($login);

    if ($user == null) { // if login not found
      $error_message = 'Nom d\'utilisateur/adresse e-mail incorrect';
    } else {
      // login found
      if ($password != $user->getPassword()) { // if password not valid
        $error_message = 'Mot de passe incorrect';
      } else {
        // login and password valids
        $_SESSION['id'] = $user->getId();
        // redirect to the "private" profil page
        header('Location: main.ctrl.php?page_type=profil');
      }
    }
  }
}

?>
