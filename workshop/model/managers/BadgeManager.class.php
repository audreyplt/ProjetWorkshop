<?php
require_once('../model/DAO.class.php');
require_once('../model/class/Badge.class.php');

/**
 * Class BadgeManager
 * the manager between the database and the class Badge
 */
class BadgeManager
{

  /**
   * Returns the badges obtained by the user from the database
   * @param User|int $user the user associated
   * @return array the badges obtained by the user from the database
   */
  public function get($user)
  {
    if ($user instanceof User) {
      $id = $user->getId();
    } else {
      $id = (int) $user;
    }

    $req = 'SELECT * FROM pw_badge, pw_b_usr WHERE b_id = bu_badge AND bu_user = :id';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $badges = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($badges, new Badge($result));
    }
    return $badges;
  }

  /**
   * Returns the badges NOT obtained by the user from the database
   * @param User|int $user the user associated
   * @return array the badges NOT obtained by the user from the database
   */
  public function getNonObtained($user)
  {
    if ($user instanceof User) {
      $id = $user->getId();
    } else {
      $id = (int) $user;
    }

    $req = 'SELECT * FROM pw_badge WHERE b_id NOT IN (SELECT b_id FROM pw_badge, pw_b_usr WHERE b_id = bu_badge AND bu_user = :id)';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $badges = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($badges, new Badge($result));
    }
    return $badges;
  }

  /**
   * Returns all the badges stored in the database
   * @return array the badges stored in the database
   */
  public function getAll()
  {
    $req = 'SELECT * FROM pw_badge';
    $sth = DAO::getDB()->prepare($req);
    $sth->execute();
    $badges = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($badges, new Badge($result));
    }
    return $badges;
  }

}