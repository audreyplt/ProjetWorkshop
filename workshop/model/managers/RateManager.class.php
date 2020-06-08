<?php
require_once('../model/DAO.class.php');
require_once('../model/class/Rate.class.php');

/**
 * Class RateManager
 * The manager between the database and the class Rate
 */
class RateManager
{
  /**
   * Returns the attributes of the Rate in an array
   * @param Rate $rate the associated rate
   * @return array the attributes of the Rate in an array
   */
  private function getProperties($rate)
  {
    $properties = array(
      ':user' => $rate->getUser()->getId(),
      ':template' => $rate->getTemplate()->getRef(),
      ':nbStar' => $rate->getNbStar(),
    );
    return $properties;
  }

  ////////// METHODES C R U M //////////

  /**
   * Returns the rates associated with the template
   * @param Template|int $template the associated template
   * @return array the rates associated with the template
   */
  public function get($template)
  {
    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    $req = 'SELECT * FROM pw_rate WHERE r_template = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
    $rates = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      array_push($rates, new Rate($result));
    }
    return $rates;
  }

  /**
   * Adds a new Rate in the database
   * @param Rate $rate the rate to add
   */
  public function add($rate)
  {
    $properties = $this->getProperties($rate);

    $req = 'INSERT INTO pw_rate VALUES (:user, :template, :nbstar)';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':user', $properties[':user'], PDO::PARAM_INT);
    $sth->bindParam(':template', $properties[':template'], PDO::PARAM_INT);
    $sth->bindParam(':nbstar', $properties[':nbStar'], PDO::PARAM_INT);
    $sth->execute();
  }

  /**
   * Updates an existing Rate in the database
   * @param Rate $rate the rate to update
   *
   */
  public function update($rate)
  {
    $properties = $this->getProperties($rate);

    $req = 'UPDATE pw_rate SET r_nb_star = :nbStar WHERE r_user = :user AND r_template = :template';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':user', $properties[':user'], PDO::PARAM_INT);
    $sth->bindParam(':template', $properties[':template'], PDO::PARAM_INT);
    $sth->bindParam(':nbStar', $properties[':nbStar'], PDO::PARAM_INT);
    $sth->execute();
  }

  /**
   * Delete an existing Rate from the database
   * @param Rate $rate the rate to delete
   */
  public function delete($rate)
  {
    $properties = $this->getProperties($rate);

    $req = 'DELETE FROM pw_rate WHERE r_user = :user AND r_template = :template';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':user', $properties[':user'], PDO::PARAM_INT);
    $sth->bindParam(':template', $properties[':template'], PDO::PARAM_INT);
    $sth->execute();
  }
}