<?php
require_once('../model/DAO.class.php');
require_once('../model/class/User.class.php');

/**
 * Class UserManager
 * The manager between the database and the class User
 */
class UserManager
{
  /**
   * Returns the attributes of the Template in an array
   * @param User $user the associated user
   * @return array the attributes of the Template in an array
   */
  private function getProperties($user)
  {
    $properties = array(
      ':id' => $user->getId(),
      ':login' => $user->getLogin(),
      ':password' => $user->getPassword(),
      ':email' => $user->getEmail(),
      ':pseudo' => $user->getPseudo(),
      ':firstName' => $user->getFirstName(),
      ':lastName' => $user->getLastName(),
      ':country' => $user->getCountry(),
      ':city' => $user->getCity(),
      ':resume' => $user->getResume(),
    );
    return $properties;
  }

  ////////// METHODES C R U M //////////

  /**
   * Returns the user with his id from the database
   * @param int $id the user's id
   * @return User|null
   */
  public function get($id)
  {
    $id = (int) $id;
    $req = 'SELECT * FROM pw_user WHERE u_id = :id';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':id', $id);
    $sth->execute();
    if ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      return new User($result);
    } else {
      return NULL;
    }
  }

  /**
   * returns all the users from the database
   * @return array all the existing users in the database
   */
  public function getAll()
  {
    $req = 'SELECT * FROM pw_user ORDER BY u_id';
    $sth = DAO::getDB()->prepare($req);
    $sth->execute();
    $users = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($users, new User($result));
    }
    return $users;
  }

  /**
   * Adds a new User in the database
   * @param User $user the user to add
   * @return int the unique id given by the database
   */
  public function add($user)
  {
    $properties = $this->getProperties($user);
    $req = 'SELECT addUser(:login, :password, :email, :pseudo, :firstName, :lastName, :country, :city, :resume)';
    $sth = DAO::getDB()->prepare($req);

    $sth->bindParam(':login', $properties[':login']);
    $sth->bindParam(':password', $properties[':password']);
    $sth->bindParam(':email', $properties[':email']);
    $sth->bindParam(':pseudo', $properties[':pseudo']);
    $sth->bindParam(':firstName', $properties[':firstName']);
    $sth->bindParam(':lastName', $properties[':lastName']);
    $sth->bindParam(':country', $properties[':country']);
    $sth->bindParam(':city', $properties[':city']);
    $sth->bindParam(':resume', $properties[':resume']);
    $sth->execute();
    $id = $sth->fetch(PDO::FETCH_BOTH);
    return $id[0];
  }

  /**
   * Updates an existing user int the database
   * @param User $user the user to update
   */
  public function update($user)
  {
    $properties = $this->getProperties($user);
    $req = 'UPDATE pw_user SET u_login = :login, u_password = :password, u_email = :email, u_pseudo = :pseudo, 
            u_first_name = :firstName, u_last_name = :lastName, u_country = :country, u_city = :city, u_resume = :resume
            WHERE u_id = :id';
    $sth = DAO::getDB()->prepare($req);

    $sth->bindParam(':id', $properties[':id'], PDO::PARAM_INT);
    $sth->bindParam(':login', $properties[':login']);
    $sth->bindParam(':password', $properties[':password']);
    $sth->bindParam(':email', $properties[':email']);
    $sth->bindParam(':pseudo', $properties[':pseudo']);
    $sth->bindParam(':firstName', $properties[':firstName']);
    $sth->bindParam(':lastName', $properties[':lastName']);
    $sth->bindParam(':country', $properties[':country']);
    $sth->bindParam(':city', $properties[':city']);
    $sth->bindParam(':resume', $properties[':resume']);

    $sth->execute();
  }

  /**
   * Deletes an existing user from the database
   * @param User|int $user the user to delete
   */
  public function delete($user)
  {
    if ($user instanceof User) {
      $id = $user->getId();
    } else {
      $id = (int) $user;
    }

    $req = 'CALL deleteUser(:id)';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }

  ////////// UTILITIES //////////

  /**
   * Returns the user with the associated login or email address. used for connection time.
   * @param string $loginOrEmail the login or the email address
   * @return User|null the user associated
   */
  public function login($loginOrEmail)
  {
    $req = 'SELECT * FROM pw_user WHERE u_login = :login OR u_email = :email';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':login', $loginOrEmail);
    $sth->bindParam(':email', $loginOrEmail);
    $sth->execute();
    if ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      return new User($result);
    } else {
      return NULL;
    }
  }
}