<?php
require_once('../model/DAO.class.php');
require_once('../model/class/AlbumTemplate.class.php');

/**
 * Class TemplateManager
 * The manager between the database and the class Template (and the differents inherited classes).
 */
class TemplateManager
{
  /**
   * Returns the attributes of the Template in an array
   * @param Template $template the associated template
   * @return array the attributes of the Template in an array
   */
  private function getProperties($template)
  {
    $properties = array(
      ':ref' => $template->getRef(),
      ':name' => $template->getName(),
      ':description' => $template->getDescription(),
      ':date' => $template->getPubDate(),
      ':topic' => $template->getTopic(),
      ':public' => $template->isPublic(),
      ':user' => $template->getUser()->getId()
    );

    if ($template instanceof AlbumTemplate) {
      $properties[':format'] = $template->getFormat();
      $properties[':size'] = $template->getSize();
    }

    // TO COMPLETE...

    return $properties;
  }

  ////////// METHODES C R U M //////////

  /**
   * Returns the template corresponding to the reference and type indicated from the database
   * @param int $ref the template's reference
   * @param string $type the template's type (AlbumTemplate, ...)
   * @return Template|null
   */
  public function get($ref, $type)
  {
    $ref = (int) $ref;

    $req = 'SELECT * FROM pw_template, ' . $type . ' WHERE t_ref = ' . $type . '.t_template AND t_ref = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
    if ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      switch ($type) {
        case DAO::ALBUM_TEMPLATE: return new AlbumTemplate($result);
        // A COMPLETER...
        default: return NULL;
      }
    } else {
      return NULL;
    }
  }

  /**
   * Returns all the templates for the type indicated
   * @param string $type the type of template
   * @return array the templates for the type indicated
   */
  public function getAll($type)
  {
    $req = 'SELECT * FROM pw_template, ' . $type . ' WHERE t_ref = ' . $type . '.t_template ORDER BY t_ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->execute();
    $templates = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      switch ($type) {
        case DAO::ALBUM_TEMPLATE: array_push($templates, new AlbumTemplate($result));
        // A COMPLETER...
      }
    }
    return $templates;
  }

  /**
   * Add a new template in the database
   * @param Template $template the template to add
   */
  public function add($template)
  {
    $properties = $this->getProperties($template);

    if ($template instanceof AlbumTemplate) {
      $req = 'SELECT addAlbumTemplate(:name, :description, :topic, :public, :user, :format, :size)';
      $sth = DAO::getDB()->prepare($req);
      $sth->bindParam(':name', $properties[':name']);
      $sth->bindParam(':description', $properties[':description']);
      $sth->bindParam(':topic', $properties[':topic']);
      $sth->bindParam(':public', $properties[':public'], PDO::PARAM_BOOL);
      $sth->bindParam(':user', $properties[':user'], PDO::PARAM_INT);
      $sth->bindParam(':format', $properties[':format']);
      $sth->bindParam(':size', $properties[':size']);
      $sth->execute();
      $ref = $sth->fetch(PDO::FETCH_BOTH);
    }

    // A COMPLETER...

    if (isset($ref) && $ref != NULL) {
      foreach ($template->getTags() as $tag) {
        $req = 'CALL addTag(:ref, :tag)';
        $sth = DAO::getDB()->prepare($req);
        $sth->bindParam(':ref', $ref[0], PDO::PARAM_INT);
        $sth->bindParam(':tag', $tag);
        $sth->execute();
      }
    }
  }

  /**
   * Updates an existing template in the database
   * @param Template $template
   */
  public function update($template)
  {
    $properties = $this->getProperties($template);

    // 1e étape - maj des informations générales
    $req = 'UPDATE pw_template SET t_name = :name, t_description = :description, t_topic = :topic, t_public = :public WHERE t_ref = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $properties[':ref'], PDO::PARAM_INT);
    $sth->bindParam(':name', $properties[':name']);
    $sth->bindParam(':description', $properties[':description']);
    $sth->bindParam(':topic', $properties[':topic']);
    $sth->bindParam(':public', $properties[':public'], PDO::PARAM_BOOL);
    $sth->execute();

    // 2e étape - maj des informations spécifiques
    if ($template instanceof AlbumTemplate) {
      $req = 'UPDATE pw_album_template SET at_format = :format, at_size = :size WHERE t_template = :ref';
    } // A COMPLETER...

    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $properties[':ref'], PDO::PARAM_INT);
    $sth->bindParam(':format', $properties[':format']);
    $sth->bindParam(':size', $properties[':size']);
    $sth->execute();
  }

  /**
   * Deletes an existing template from the database
   * @param Template|int $template the template to delete
   */
  public function delete($template)
  {
    if ($template instanceof Template) {
      $ref = $template->getRef();
    } else {
      $ref = (int) $template;
    }

    // Attributs spécifiques (album_template, ...) => suppression en CASCADE.
    // Tags => suppression en CASCADE
    $req = 'DELETE FROM pw_template WHERE t_ref = :ref';
    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':ref', $ref, PDO::PARAM_INT);
    $sth->execute();
  }

  ////////// METHODES UTILITAIRES //////////

  /**
   * Returns the templates belonging to the specified user
   * @param User|int $user the associated user (or id)
   * @return array the templates belonging to the specified user
   */
  public function getForUser($user)
  {
    if ($user instanceof User) {
      $id = $user->getId();
    } else {
      $id = (int) $user;
    }

    $templates = array();
    foreach(DAO::$_templatesTables as $table) {
      $req = 'SELECT * FROM pw_template, ' . $table . ' WHERE ' . $table . '.t_template = t_ref AND t_user = :id';
      $sth = DAO::getDB()->prepare($req);
      $sth->bindParam(':id', $id);
      $sth->execute();
      while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
        switch ($table) {
          case DAO::ALBUM_TEMPLATE: array_push($templates, new AlbumTemplate($result));
          // A COMPLETER...
        }
      }
    }
    return $templates;
  }

  /**
   * Filtering: Returns the templates respecting the different criteria in arguments
   * @param string $type the template's type
   * @param array $keywords array for the name search
   * @param array $topics restriction on topics
   * @param float $rateMin restriction on the minimal rate
   * @param array $formats restriction on the template's format
   * @param array $sizes restriction on the size's format
   * @return array the templates respecting the different criteria in arguments
   */
  public function getFiltered($type, $keywords, $topics, $rateMin, $formats, $sizes)
  {
    $req = 'SELECT * FROM pw_template, ' . $type . ' WHERE t_ref = t_template';

    // keywords : names, tags, creators
    if (isset($keywords) && $keywords != null) {
      // names
      $req .= ' AND (';
      foreach($keywords as $keyword) {
        $req .= ($keyword == $keywords[0] ? '' : ' OR ') . 't_name LIKE \'%' . $keyword . '%\'';
      }
      $req .= ')';
      // tags
      // - PAS ENCORE DISPONIBLE
      // creators
      // - PAS ENCORE DISPONIBLE
    }

    // topics
    if (isset($topics) && $topics != null) {
      $req .= ' AND t_topic IN (';
      foreach($topics as $topic) {
        $req .= ($topic == $topics[0] ? '' : ', ') . '\'' . $topic . '\'';
      }
      $req .= ')';
    }

    // rateMin
    if (isset($rateMin) && $rateMin != null) {
      $req .= ' AND (SELECT AVG(r_nb_star) FROM pw_rate WHERE r_template = t_ref) >= :rateMin';
    }

    switch ($type) {
      case DAO::ALBUM_TEMPLATE:
        // formats
        if (isset($formats) && $formats != null) {
          $req .= ' AND at_format IN (';
          foreach($formats as $format) {
            $req .= ($format == $formats[0] ? '' : ', ') . '\'' . $format . '\'';
          }
          $req .= ')';
        }

        // sizes
        if (isset($sizes) && $sizes != null) {
          $req .= ' AND at_size IN (';
          foreach($sizes as $size) {
            $req .= ($size == $sizes[0] ? '' : ', ') . '\'' . $size . '\'';
          }
          $req .= ')';
        }
        break;
    }

    $sth = DAO::getDB()->prepare($req);
    $sth->bindParam(':rateMin', $rateMin);
    $sth->execute();
    $templates = array();
    while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
      switch ($type) {
        case DAO::ALBUM_TEMPLATE: array_push($templates, new AlbumTemplate($result));
        // A COMPLETER...
      }
    }
    return $templates;
  }
}
