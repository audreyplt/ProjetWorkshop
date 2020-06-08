<?php
require_once('../model/DAO.class.php');
require_once('../model/class/AlbumTemplate.class.php');

/**
 * Class FavoriteManager
 * The manager between the database and the user's favorites templates
 */
class FavoriteManager
{
  ////////// MTHODES C R U M //////////

  /**
   * Returns a array of user's favorite Template
   * @param User|int $user the user associated
   * @return array the array of user's favorites Template
   */
  public function get($user)
  {
    if ($user instanceof User) {
      $id = $user->getId();
    } else {
      $id = (int) $user;
    }

    $templates = array();
    foreach(DAO::$_templatesTables as $table) {
      $req = 'SELECT * FROM pw_favorite, pw_template, ' . $table . ' WHERE f_user = :id AND f_template = t_ref AND t_ref = ' . $table . '.t_template';
      $sth = DAO::getDB()->prepare($req);
      $sth->bindParam(':id', $id);
      $sth->execute();
      while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
        switch ($table) {
          case DAO::ALBUM_TEMPLATE: array_push($templates, new AlbumTemplate($result));
          // A COMPLETER ...
        }
      }
    }
    return $templates;
  }

  /**
   * Adds a new favorite association in the database
   * @param User|int $user the associated user
   * @param Template $template the associated template
   */
  public function add($user, $template)
  {
    if ($template->isPublic()) {
      if ($user instanceof User) {
        $id = $user->getId();
      } else {
        $id = (int) $user;
      }

      if ($template instanceof Template) {
        $ref = $template->getRef();
      } else {
        $ref = (int) $template;
      }

      $req = 'INSERT INTO pw_favorite VALUES (:id, :ref)';
      $sth = DAO::getDB()->prepare($req);
      $sth->bindParam(':id', $id);
      $sth->bindParam(':ref', $ref);
      $sth->execute();
    }
  }

  /**
   * Deletes a favorite association from the database
   * @param User|int $user the associated user
   * @param Template|int $template the associated template
   */
  public function delete($user, $template)
  {
    if ($user instanceof User) {
      $id = $user->getId();
    } else {
      $id = (int) $user;
    }

    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    $req = 'DELETE FROM pw_favorite WHERE f_user = :id AND f_template = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':id', $id);
    $sth->bindParam(':ref', $ref);
    $sth->execute();
  }
}