<?php
require_once('../model/DAO.class.php');
require_once('../model/class/Commentary.class.php');

/**
 * Class CommentaryManager
 * the manager between the database and the class Commentary
 */
class CommentaryManager
{
  /**
   * Returns the attributes of the commentary in an array
   * @param Commentary $commentary the associated commentary
   * @return array the attributes of the commentary in an array
   */
  private function getProperties($commentary)
  {
    $properties = array(
      ':user' => $commentary->getUser()->getId(),
      ':template' => $commentary->getTemplate()->getRef(),
      ':datePub' => $commentary->getPubDate(),
      ':text' => $commentary->getText(),
    );
    return $properties;
  }

  ////////// METHODES C R U M //////////

  /**
   * Returns a new instance of Commentary from its reference
   * @param int $ref the commentary's unique reference
   * @return Commentary|null
   */
  public function get($ref)
  {
    $req = 'SELECT * FROM pw_commentary WHERE c_ref = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
    if ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      return new Commentary($result);
    } else {
      return NULL;
    }
  }

  /**
   * Returns all Commentary associated with the template
   * @param int|Template $template the template associated
   * @return array array of Commentary associated with the template
   */
  public function getAll($template)
  {
    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    $req = 'SELECT * FROM pw_commentary WHERE c_template = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
    $commentaries = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($commentaries, new Commentary($result));
    }
    return $commentaries;
  }

  /**
   * Adds a new Commentary in the database
   * @param Commentary $commentary the new commentary to add
   */
  public function add($commentary)
  {
    $properties = $this->getProperties($commentary);

    $req = 'INSERT INTO pw_commentary (c_user, c_template, c_publication_date, c_text) VALUES (:user, :template, now(), :text)';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':user', $properties[':user'], PDO::PARAM_INT);
    $sth->bindParam(':template', $properties[':template'], PDO::PARAM_INT);
    $sth->bindParam(':text', $properties[':text']);
    $sth->execute();
  }

  /**
   * Updates an existing commentary in the database
   * @param Commentary $commentary the commentary to update
   */
  public function update($commentary)
  {
    $properties = $this->getProperties($commentary);

    $req = 'UPDATE pw_commentary SET c_text = :text WHERE c_user = :user AND c_template = :template';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':user', $properties[':user'], PDO::PARAM_INT);
    $sth->bindParam(':template', $properties[':template'], PDO::PARAM_INT);
    $sth->bindParam(':text', $properties[':text']);
    $sth->execute();
  }

  /**
   * Deletes an existing commentary from the database
   * @param int|Commentary $commentary the commentary to delete
   */
  public function delete($commentary)
  {
    if ($commentary instanceof Commentary) {
      $ref = $commentary->getRef();
    } else {
      $ref = (int) $commentary;
    }

    $req = 'DELETE FROM pw_commentary WHERE c_ref = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
  }
}