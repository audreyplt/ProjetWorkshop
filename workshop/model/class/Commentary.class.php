<?php
/**
 * Class Commentary
 * Comments on the templates
 */
class Commentary implements Countable
{
  /**
   * @var int the commentary's unique reference
   */
  private $_ref;

  /**
   * @var string the commentary's date of publication
   */
  private $_pubDate;

  /**
   * @var string the commentary's text
   */
  private $_text;

  /**
   * @var User|int the User (or his ID), owner of the commentary
   */
  private $_user;

  /**
   * @var Template|int the associated template
   */
  private $_template;

  /**
   * Commentary constructor.
   * @param array $datas array of data retrieved from the database
   */
  public function __construct($datas)
  {
    $this->hydrate($datas);
  }

  /**
   * Hydration function
   * @param array $datas array of data retrieved from the database
   */
  protected function hydrate($datas)
  {
    foreach ($datas as $key => $value) {
      switch ($key) {
        case 'c_ref':
          $this->setRef($value);
          break;
        case 'c_user':
          $this->setUser($value);
          break;
        case 'c_template':
          $this->setTemplate($value);
          break;
        case 'c_publication_date':
          $this->setPubDate($value);
          break;
        case 'c_text':
          $this->setText($value);
          break;
      }
    }
  }

  /**
   * useless function to disable the warning
   * @return int|void
   */
  public function count()
  {
    // NOTHING TO DO...
  }

  ////////// GETTERS & SETTERS //////////

  /**
   * Returns the commentary's unique reference
   * @return int the commentary's unique reference
   */
  public function getRef()
  {
    return $this->_ref;
  }

  /**
   * Affects the commentary's unique reference
   * @param int $ref the commentary's unique reference
   */
  public function setRef($ref)
  {
    $this->_ref = $ref;
  }

  /**
   * Returns the commentary's date of publication
   * @return string the commentary's date of publication
   */
  public function getPubDate()
  {
    return $this->_pubDate;
  }

  /**
   * Affects the commentary's date of publication
   * @param string $pubDate the commentary's date of publication
   */
  public function setPubDate($pubDate)
  {
    $this->_pubDate = $pubDate;
  }

  /**
   * Returns the commentary's text
   * @return string the commentary's text
   */
  public function getText()
  {
    return $this->_text;
  }

  /**
   * Affects the commentary's text
   * @param string $text the commentary's text
   */
  public function setText($text)
  {
    $this->_text = $text;
  }

  /**
   * Returns the commentary's owner
   * @return User|int the commentary's owner
   */
  public function getUser()
  {
    return $this->_user;
  }

  /**
   * Affects the commentary's owner
   * @param User $user the commentary's owner
   */
  public function setUser($user)
  {
    $this->_user = $user;
  }

  /**
   * Returns the associated template
   * @return Template the associated template
   */
  public function getTemplate()
  {
    return $this->_template;
  }

  /**
   * Affects the associated template
   * @param Template $template the associated template
   */
  public function setTemplate($template)
  {
    $this->_template = $template;
  }
}