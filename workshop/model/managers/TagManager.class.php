<?php
require_once('../model/DAO.class.php');
require_once('../model/class/Template.class.php');

/**
 * Class TagManager
 * The manager between the database and the template's tags
 */
class TagManager
{
  ////////// METHODES C R U M //////////

  /**
   * Returns all the tags associated with the template
   * @param Template|int $template the associated template
   * @return array the tags associated with the template
   */
  public function get($template)
  {
    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    $req = 'SELECT ta_libelle FROM pw_tag, pw_t_tag WHERE ta_ref = tt_tag AND tt_template = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
    $tags = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($tags, $result['ta_libelle']);
    }
    return $tags;
  }

  /**
   * Adds a new tag for a template in the database
   * @param Template|int $template the associated template
   * @param string $tag the tag to add
   */
  public function add($template, $tag)
  {
    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    $req = 'CALL addTag(:template, :tag)';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':template', $ref, PDO::PARAM_INT);
    $sth->bindParam(':tag', $tag);
    $sth->execute();
  }

  /**
   * Deletes an existing template's tag from the database
   * @param Template[int $template the associated template
   * @param string $tag the tag to delete
   */
  public function delete($template, $tag)
  {
    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    $req = 'DELETE FROM pw_t_tag WHERE tt_template = :ref AND tt_tag = :tag';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->bindParam(':tag', $tag);
    $sth->execute();
  }
}