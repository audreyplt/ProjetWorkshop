<?php
/**
 * Class Rate
 * Rates on the templates
 */
class Rate
{
  /**
   * int the max number of star for one rate
   */
  const MAX_RATE = 5;

  /**
   * @var int the number of star
   */
  private $_nbStar;

  /**
   * @var User|int the user who put the rate
   */
  private $_user;

  /**
   * @var Template|int the template associated
   */
  private $_template;

  /**
   * Rate constructor.
   * @param array $datas array of data retrieved from the database
   */
  public function __construct($datas)
  {
    $this->hydrate($datas);
  }

  /**
   * Hydration function
   * @param $datas array of data retrieved from the database
   */
  protected function hydrate($datas)
  {
    foreach ($datas as $key => $value) {
      switch ($key) {
        case 'r_user':
          $this->setUser($value);
          break;
        case 'r_template':
          $this->setTemplate($value);
          break;
        case 'r_nb_star':
          $this->setNbStar($value);
          break;
      }
    }
  }

  ////////// GETTERS & SETTERS //////////

  /**
   * Returns the number of stars
   * @return int the number of stars
   */
  public function getNbStar()
  {
    return $this->_nbStar;
  }

  /**
   * Affects the number of stars
   * @param int $nbStar the number of stars
   */
  public function setNbStar($nbStar)
  {
    if ($nbStar >= 0 && $nbStar <= self::MAX_RATE) {
      $this->_nbStar = $nbStar;
    }
  }

  /**
   * Returns the user who put the rate
   * @return User|int the user who put the rate
   */
  public function getUser()
  {
    return $this->_user;
  }

  /**
   * Affects the user who put the rate
   * @param User|int $user
   */
  public function setUser($user)
  {
    $this->_user = $user;
  }

  /**
   * Returns the template associated
   * @return Template the template associated
   */
  public function getTemplate()
  {
    return $this->_template;
  }

  /**
   * Affects the template associated
   * @param Template $template the template associated
   */
  public function setTemplate($template)
  {
    $this->_template = $template;
  }
}