<?php
require_once('../model/DAO.class.php');

require_once('../model/managers/TemplateManager.class.php');
require_once('../model/managers/UserManager.class.php');
require_once('../model/managers/RateManager.class.php');
require_once('../model/managers/CommentaryManager.class.php');
require_once('../model/managers/FavoriteManager.class.php');
require_once('../model/managers/TagManager.class.php');
require_once('../model/managers/BadgeManager.class.php');

/**
 * Class SuperManager
 * the manager of all other managers. It is through him and only through him that the controler part passes to get data from the database
 */
class SuperManager
{
  ////////// USERS MANAGEMENT //////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Gets the user from his id.
   * @param int $id the user's unique id
   * @return User|null
   */
  public function getUser($id)
  {
    try {
      DAO::getDB()->beginTransaction();

      $userManager = new UserManager();
      $user = $userManager->get($id);

      // templates adding
      $templateManager = new TemplateManager();
      $user_templates = $templateManager->getForUser($id);

      $userManager = new UserManager();
      $tagManager = new TagManager();
      $rateManager = new RateManager();
      $commentaryManager = new CommentaryManager();
      foreach ($user_templates as $template) {
        $template->setUser($userManager->get($template->getUser()));
        $template->setCommentaries($commentaryManager->getAll($template->getRef()));
        $template->setRates($rateManager->get($template->getRef()));
        $template->setTags($tagManager->get($template));
      }

      $user->setTemplates($user_templates);


      // favorites adding
      $favoriteManager = new FavoriteManager();
      $user->setFavorites($favoriteManager->get($id));

      DAO::getDB()->commit();
      return $user;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Gets all users from the DB.
   * @return array the users
   */
  public function getAllUsers()
  {
    try {
      DAO::getDB()->beginTransaction();

      $userManager = new UserManager();
      $users = $userManager->getAll();

      // creations & favorites adding
      $templateManager = new TemplateManager();
      $favoriteManager = new FavoriteManager();
      foreach ($users as $user) {
        $user->setTemplates($templateManager->getForUser($user));
        $user->setFavorites($favoriteManager->get($user));
      }

      DAO::getDB()->commit();
      return $users;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Adds a new user in the database
   * @param User $user the user to add.
   * @return int
   */
  public function addUser($user)
  {
    try {
      DAO::getDB()->beginTransaction();

      $userManager = new UserManager();
      $id = $userManager->add($user);

      DAO::getDB()->commit();
      return $id;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur - addUser : ' . $e->getMessage());
    }
  }

  /**
   * Updates the corresponding user in the DB.
   * @param User $user the user to update
   */
  public function updateUser($user)
  {
    try {
      DAO::getDB()->beginTransaction();
      $userManager = new UserManager();
      $userManager->update($user);
      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Deletes the corresponding customer from the DB.
   * @param User|int $user the user to delete
   */
  public function deleteUser($user)
  {
    try {
      DAO::getDB()->beginTransaction();

      $userManager = new UserManager();
      $userManager->delete($user);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Returns the user with the associated login or email address. used for connection time.
   * @param string $loginOrEmail the login or the email address
   * @return User|null
   */
  public function loginUser($loginOrEmail)
  {
    try {
      DAO::getDB()->beginTransaction();

      $userManager = new UserManager();
      $user = $userManager->login($loginOrEmail);

      DAO::getDB()->commit();
      return $user;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  ////////// TEMPLATES MANAGEMENT //////////////////////////////////////////////////////////////////////////////////////

  /**
   * Gets the template from his reference and his type.
   * @param int $ref the template's reference
   * @param string $type the template's type
   * @return Template|null
   */
  public function getTemplate($ref, $type)
  {
    try {
      DAO::getDB()->beginTransaction();

      $templateManager = new TemplateManager();
      $userManager = new UserManager();
      $tagManager = new TagManager();
      $rateManager = new RateManager();
      $commentaryManager = new CommentaryManager();

      $template = $templateManager->get($ref, $type);
      // ajout du créateur
      $template->setUser($userManager->get($template->getUser()));
      // ajout des tags
      $template->setTags($tagManager->get($template));
      // ajout des notes
      $template->setRates($rateManager->get($ref));
      // ajout des commentaires
      $template->setCommentaries($commentaryManager->getAll($ref));

      DAO::getDB()->commit();
      return $template;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Gets all templates of specified type from the DB.
   * @param string $type the template's type
   * @return array the templates of the specified type
   */
  public function getTemplatesType($type)
  {
    try {
      DAO::getDB()->beginTransaction();

      $templateManager = new TemplateManager();
      $templates = $templateManager->getAll($type);

      // ajout du créateur, des tags, des notes, des commentaires.
      $userManager = new UserManager();
      $tagManager = new TagManager();
      $rateManager = new RateManager();
      $commentaryManager = new CommentaryManager();
      foreach ($templates as $template) {
        $template->setUser($userManager->get($template->getUser()));
        $template->setCommentaries($commentaryManager->getAll($template->getRef()));
        $template->setRates($rateManager->get($template->getRef()));
        $template->setTags($tagManager->get($template));
      }

      DAO::getDB()->commit();
      return $templates;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
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
  public function getTemplatesFiltered($type, $keywords, $topics, $rateMin, $formats, $sizes)
  {
    try {
      DAO::getDB()->beginTransaction();

      $templateManager = new TemplateManager();
      $templates = $templateManager->getFiltered($type, $keywords, $topics, $rateMin, $formats, $sizes);

      $userManager = new UserManager();
      $tagManager = new TagManager();
      $rateManager = new RateManager();
      $commentaryManager = new CommentaryManager();
      foreach ($templates as $template) {
        $template->setUser($userManager->get($template->getUser()));
        $template->setCommentaries($commentaryManager->getAll($template->getRef()));
        $template->setRates($rateManager->get($template->getRef()));
        $template->setTags($tagManager->get($template));
      }

      DAO::getDB()->commit();
      return $templates;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Returns all the templates from the database
   * @return array all the templates
   */
  public function getAllTemplates()
  {
    $templates = array();
    foreach (DAO::$_templatesTables as $table) {
      $templates = array_merge($templates, $this->getTemplatesType($table));
    }
    return $templates;
  }

  /**
   * Add a new template in the database
   * @param Template $template the template to add
   */
  public function addTemplate($template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $templateManager = new TemplateManager();
      $templateManager->add($template);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Updates an existing template in the database
   * @param Template $template
   */
  public function updateTemplate($template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $templateManager = new TemplateManager();
      $templateManager->update($template);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Deletes an existing template from the database
   * @param Template|int $template the template to delete
   */
  public function deleteTemplate($template)
  {
    try {
      DAO::getDB()->beginTransaction();
      // suppression des tags : CASCADE
      // suppression de ses notes : CASCADE
      // suppression de ses commentaires : CASCADE
      // suppression des favoris : CASCADE
      // suppression du template
      $templateManager = new TemplateManager();
      $templateManager->delete($template);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  ////////// RATES MANAGEMENT //////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Returns the rates associated with the template
   * @param Template|int $template the associated template
   * @return array the rates associated with the template
   */
  public function getRate($template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $rateManager = new RateManager();
      $rates = $rateManager->get($template);

      DAO::getDB()->commit();
      return $rates;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Adds a new Rate in the database
   * @param Rate $rate the rate to add
   */
  public function addRate($rate)
  {
    try {
      DAO::getDB()->beginTransaction();

      $rateManager = new RateManager();
      $rateManager->add($rate);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Updates an existing Rate in the database
   * @param Rate $rate the rate to update
   *
   */
  public function updateRate($rate)
  {
    try {
      DAO::getDB()->beginTransaction();

      $rateManager = new RateManager();
      $rateManager->update($rate);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Delete an existing Rate from the database
   * @param Rate $rate the rate to delete
   */
  public function deleteRate($rate)
  {
    try {
      DAO::getDB()->beginTransaction();

      $rateManager = new RateManager();
      $rateManager->delete($rate);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  ////////// COMMENTARIES MANAGEMENT ///////////////////////////////////////////////////////////////////////////////////

  /**
   * Returns a new instance of Commentary from its reference
   * @param int $ref the commentary's unique reference
   * @return Commentary|null
   */
  public function getCommentary($ref)
  {
    try {
      DAO::getDB()->beginTransaction();

      $commentaryManager = new CommentaryManager();
      $commentary = $commentaryManager->get($ref);

      $commentary->setUser($this->getUser($commentary->getUser()));

      DAO::getDB()->commit();
      return $commentary;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Returns all Commentary associated with the template
   * @param int|Template $template the template associated
   * @return array array of Commentary associated with the template
   */
  public function getCommentaries($template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $commentaryManager = new CommentaryManager();
      $commentaries = $commentaryManager->getAll($template);

      // users adding
      foreach ($commentaries as $commentary) {
        $commentary->setUser($this->getUser($commentary->getUser()));
      }

      DAO::getDB()->commit();
      return $commentaries;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Adds a new Commentary in the database
   * @param Commentary $commentary the new commentary to add
   */
  public function addCommentary($commentary)
  {
    try {
      DAO::getDB()->beginTransaction();

      $commentaryManager = new CommentaryManager();
      $commentaryManager->add($commentary);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Updates an existing commentary in the database
   * @param Commentary $commentary the commentary to update
   */
  public function updateCommentary($commentary)
  {
    try {
      DAO::getDB()->beginTransaction();

      $commentaryManager = new CommentaryManager();
      $commentaryManager->update($commentary);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Deletes an existing commentary from the database
   * @param int|Commentary $commentary the commentary to delete
   */
  public function deleteCommentary($commentary)
  {
    try {
      DAO::getDB()->beginTransaction();

      $commentaryManager = new CommentaryManager();
      $commentaryManager->delete($commentary);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  ////////// FAVORITES MANAGEMENT //////////////////////////////////////////////////////////////////////////////////////

  /**
   * Returns a array of user's favorite Template
   * @param User|int $user the user associated
   * @return array the array of user's favorites Template
   */
  public function getFavorites($user)
  {
    try {
      DAO::getDB()->beginTransaction();

      $favoriteManager = new FavoriteManager();
      $favorites = $favoriteManager->get($user);

      DAO::getDB()->commit();
      return $favorites;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Adds a new favorite association in the database
   * @param User|int $user the associated user
   * @param Template $template the associated template
   */
  public function addFavorite($user, $template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $favoriteManager = new FavoriteManager();
      $favoriteManager->add($user, $template);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Deletes a favorite association from the database
   * @param User|int $user the associated user
   * @param Template|int $template the associated template
   */
  public function deleteFavorite($user, $template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $favoriteManager = new FavoriteManager();
      $favoriteManager->delete($user, $template);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  ////////// TAGS MANAGEMENT ///////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Returns all the tags associated with the template
   * @param Template|int $template the associated template
   * @return array the tags associated with the template
   */
  public function getTag($template)
  {
    try {
      DAO::getDB()->beginTransaction();

      $tagManager = new TagManager();
      $tags = $tagManager->get($template);

      DAO::getDB()->commit();
      return $tags;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Adds a new tag for a template in the database
   * @param Template|int $template the associated template
   * @param string $tag the tag to add
   */
  public function addTag($template, $tag)
  {
    try {
      DAO::getDB()->beginTransaction();

      $tagManager = new TagManager();
      $tagManager->add($template, $tag);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Deletes an existing template's tag from the database
   * @param Template[int $template the associated template
   * @param string $tag the tag to delete
   */
  public function deleteTag($template, $tag)
  {
    try {
      DAO::getDB()->beginTransaction();

      $tagManager = new TagManager();
      $tagManager->delete($template, $tag);

      DAO::getDB()->commit();
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  ////////// BADGES MANAGEMENT /////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Returns all the badges stored in the database
   * @return array the badges stored in the database
   */
  public function getAllBadges()
  {
    try {
      DAO::getDB()->beginTransaction();

      $badgeManager = new BadgeManager();
      $badges = $badgeManager->getAll();

      DAO::getDB()->commit();
      return $badges;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Returns the badges obtained by the user from the database
   * @param User|int $user the user associated
   * @return array the badges obtained by the user from the database
   */
  public function getUserBadges($user)
  {
    try {
      DAO::getDB()->beginTransaction();

      $badgeManager = new BadgeManager();
      $badges = $badgeManager->get($user);

      DAO::getDB()->commit();
      return $badges;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

  /**
   * Returns the badges NOT obtained by the user from the database
   * @param User|int $user the user associated
   * @return array the badges NOT obtained by the user from the database
   */
  public function getBadgesNonObtained($user)
  {
    try {
      DAO::getDB()->beginTransaction();

      $badgeManager = new BadgeManager();
      $badges = $badgeManager->getNonObtained($user);

      DAO::getDB()->commit();
      return $badges;
    } catch (Exception $e) {
      DAO::getDB()->rollBack();
      die('Erreur : ' . $e->getMessage());
    }
  }

}
