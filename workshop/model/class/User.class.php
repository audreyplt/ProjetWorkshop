<?php
/**
 * Class User
 * Class grouping user data
 */
class User
{
  /**
   * @var int unique user ID
   */
  private $_id;

  /**
   * @var string connection identifier
   */
  private $_login;

  /**
   * @var string user password
   */
  private $_password;

  /**
   * @var string user's email address
   */
  private $_email;

  /**
   * @var string public name of the user
   */
  private $_pseudo;

  /**
   * @var string users' first name
   */
  private $_firstName;

  /**
   * @var string user's last name
   */
  private $_lastName;

  /**
   * @var string user's country
   */
  private $_country;

  /**
   * @var string user's city
   */
  private $_city;

  /**
   * @var string description of the user (quotation, currency,...)
   */
  private $_resume;

  /**
   * @var array array of Template associated with the user
   */
  private $_templates;

  /**
   * @var array array of Template bookmarked by the user
   */
  private $_favorites;

  /**
   * @var array array of Rate put by the user
   */
  private $_rates;

  /**
   * @var array array of Commentary put by the user
   */
  private $_commentaries;

  /**
   * @var array array of Badge acquired by the user
   */
  private $_badges;

  /**
   * @var string name to identify the user's avatar in the storage
   */
  private $_avatar;

  /**
   * string the relative path of the user's avatar
   */
  const AVATAR_PATH = '../view/resources/avatar/';

  /**
   * User constructor.
   * @param array $datas array of data retrieved from the database
   */
  public function __construct($datas)
  {
    $this->_templates = array();
    $this->_favorites = array();
    $this->_rates = array();
    $this->_commentaries = array();
    $this->_badges = array();

    $this->hydrate($datas);
  }

  /**
   * Hydration function
   * @param array $datas array of data retrieved from the database
   */
  protected function hydrate(array $datas)
  {
    foreach ($datas as $key => $value) {
      switch ($key) {
        case 'u_id':
          $this->setId($value);
          break;
        case 'u_login':
          $this->setLogin($value);
          break;
        case 'u_password':
          $this->setPassword($value);
          break;
        case 'u_email':
          $this->setEmail($value);
          break;
        case 'u_pseudo':
          $this->setPseudo($value);
          break;
        case 'u_first_name':
          $this->setFirstName($value);
          break;
        case 'u_last_name':
          $this->setLastName($value);
          break;
        case 'u_country':
          $this->setCountry($value);
          break;
        case 'u_city':
          $this->setCity($value);
          break;
        case 'u_resume':
          $this->setResume($value);
          break;
		case 'u_avatar':
		  $this->setAvatar($value);
		  break;
      }
    }
  }

  ////////// GETTERS & SETTERS //////////

  /**
   * Returns the user ID
   * @return int the user ID
   */
  public function getId()
  {
    return $this->_id;
  }

  /**
   * Affects the user ID
   * @param int $id the user ID
   */
  public function setId($id)
  {
    $this->_id = $id;
  }

  /**
   * Returns the user's login
   * @return string the user's login
   */
  public function getLogin()
  {
    return $this->_login;
  }

  /**
   * Affects the user's login
   * @param string $login the user's login
   */
  public function setLogin($login)
  {
    $this->_login = $login;
  }

  /**
   * Returns the user password
   * @return string the user password
   */
  public function getPassword()
  {
    return $this->_password;
  }

  /**
   * Affects the user password
   * @param string $password the user password
   */
  public function setPassword($password)
  {
    $this->_password = $password;
  }

  /**
   * Returns the user's email address
   * @return string the user's email address
   */
  public function getEmail()
  {
    return $this->_email;
  }

  /**
   * Affects the user's email address
   * @param string $email the user's email address
   */
  public function setEmail($email)
  {
    $this->_email = $email;
  }

  /**
   * Returns the user's public name
   * @return string the user's public name
   */
  public function getPseudo()
  {
    return $this->_pseudo;
  }

  /**
   * Affects the user's public name
   * @param string $pseudo the user's public name
   */
  public function setPseudo($pseudo)
  {
    $this->_pseudo = $pseudo;
  }

  /**
   * Returns the user's first name
   * @return string the user's first name
   */
  public function getFirstName()
  {
    return $this->_firstName;
  }

  /**
   * Affects the user's first name
   * @param string $firstName the user's first name
   */
  public function setFirstName($firstName)
  {
    $this->_firstName = $firstName;
  }

  /**
   * Returns the user's last name
   * @return string the user's last name
   */
  public function getLastName()
  {
    return $this->_lastName;
  }

  /**
   * Affects the user's last name
   * @param string $lastName the user's last name
   */
  public function setLastName($lastName)
  {
    $this->_lastName = $lastName;
  }

  /**
   * Returns the user's country
   * @return string the user's country
   */
  public function getCountry()
  {
    return $this->_country;
  }

  /**
   * Affects the user's country
   * @param string $country the user's country
   */
  public function setCountry($country)
  {
    $this->_country = $country;
  }

  /**
   * Returns the user's city
   * @return string the user's city
   */
  public function getCity()
  {
    return $this->_city;
  }

  /**
   * Affects the user's city
   * @param string $city the user's city
   */
  public function setCity($city)
  {
    $this->_city = $city;
  }

  /**
   * Returns the user's description
   * @return string the user's description
   */
  public function getResume()
  {
    return $this->_resume;
  }

  /**
   * Affects the user's description
   * @param string $resume the user's description
   */
  public function setResume($resume)
  {
    $this->_resume = $resume;
  }

  /**
   * Returns the array of Template associated with the user
   * @return array the array of Template associated with the user
   */
  public function getTemplates()
  {
    return $this->_templates;
  }

  /**
   * Affects the array of Template associated with the user
   * @param array $templates the array of Template associated with the user
   */
  public function setTemplates($templates)
  {
    $this->_templates = $templates;
  }

  /**
   * Returns the array of bookmarked Template of the user
   * @return array the array of bookmarked Template of the user
   */
  public function getFavorites()
  {
    return $this->_favorites;
  }

  /**
   * Affects the array of bookmarked Template of the user
   * @param array $favorites the array of bookmarked Template of the user
   */
  public function setFavorites($favorites)
  {
    $this->_favorites = $favorites;
  }

  /**
   * Returns the array of Rate put by the user
   * @return array the array of Rate put by the user
   */
  public function getRates()
  {
    return $this->_rates;
  }

  /**
   * Affects the array of Rate put by the user
   * @param array $rates the array of Rate put by the user
   */
  public function setRates($rates)
  {
    $this->_rates = $rates;
  }

  /**
   * Returns the array of Commentary put by the user
   * @return array the array of Commentary put by the user
   */
  public function getCommentaries()
  {
    return $this->_commentaries;
  }

  /**
   * Affects the array of Commentary put by the user
   * @param array $commentaries the array of Commentary put by the user
   */
  public function setCommentaries($commentaries)
  {
    $this->_commentaries = $commentaries;
  }

  /**
   * Returns the array of Badge acquired by the user
   * @return array the array of Badge acquired by the user
   */
  public function getBadges()
  {
    return $this->_badges;
  }

  /**
   * Affects the array of Badge acquired by the user
   * @param array $badges the array of Badge acquired by the user
   */
  public function setBadges($badges)
  {
    $this->_badges = $badges;
  }
  
  /**
   * Returns the relative path of the user's avatar in the storage
   * @return string the relative path of the user's avatar in the storage
   */
  public function getAvatar()
  {
    if ($this->_avatar != null) {
      return self::AVATAR_PATH . $this->_avatar;
    } else {
      return null;
    }
  }

  /**
   * Affects the name to identify the user's avatar in the storage
   * @param string $avatar the name to identify the user's avatar in the storage
   */
  public function setAvatar($avatar)
  {
    $this->_avatar = $avatar;
  }
}