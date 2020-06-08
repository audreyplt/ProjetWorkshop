<?php
/**
 * Class Template
 * Class grouping template data
 */
abstract class Template
{
  /**
   * @var int the template's reference
   */
  private $_ref;

  /**
   * @var string the template's name
   */
  private $_name;

  /**
   * @var string the template's description
   */
  private $_description;

  /**
   * @var string the template's date of publication
   */
  private $_pubDate;

  /**
   * @var string the template's topic
   */
  private $_topic;

  /**
   * @var boolean set if the template is visible by all (true) of not (false)
   */
  private $_public;

  /**
   * @var User|int the creator
   */
  private $_user;

  /**
   * @var array the array of Tag associated with the template
   */
  private $_tags;

  /**
   * @var array the array of Rate associated with the template
   */
  private $_rates;

  /**
   * @var array the array of Commentary associated with the template
   */
  private $_commentaries;

  /**
   * @var string (temp) the preview image of the template
   */
  private $_preview;

  /**
   * string the relative path of the template's preview
   */
  const PREVIEW_PATH = '../view/resources/template_preview/';

  /**
   * Template constructor.
   * @param array $datas array of data retrieved from the database
   */
  public function __construct($datas)
  {
    $this->_tags = array();
    $this->_rates = array();
    $this->_commentaries = array();

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
        case 't_ref':
          $this->setRef($value);
          break;
        case 't_name':
          $this->setName($value);
          break;
        case 't_description':
          $this->setDescription($value);
          break;
        case 't_publication_date':
          $this->setPubDate($value);
          break;
        case 't_topic':
          $this->setTopic($value);
          break;
        case 't_public':
          $this->setPublic($value);
          break;
        case 't_user':
          $this->setUser($value);
          break;
		case 't_preview':
		  $this->setPreview($value);
		  break;
      }
    }
  }

  ////////// GETTERS & SETTERS //////////

  /**
   * Returns the template's reference
   * @return int the template's reference
   */
  public function getRef()
  {
    return $this->_ref;
  }

  /**
   * Affects the template's reference
   * @param int $ref the template's reference
   */
  public function setRef($ref)
  {
    $this->_ref = $ref;
  }

  /**
   * Returns the template's name
   * @return string the template's name
   */
  public function getName()
  {
    return $this->_name;
  }

  /**
   * Affects the template's name
   * @param string $name the template's name
   */
  public function setName($name)
  {
    $this->_name = $name;
  }

  /**
   * Returns the template's description
   * @return string the template's description
   */
  public function getDescription()
  {
    return $this->_description;
  }

  /**
   * Affects the template's description
   * @param string $description the template's description
   */
  public function setDescription($description)
  {
    $this->_description = $description;
  }

  /**
   * Returns the date of publication
   * @return string the date of publication
   */
  public function getPubDate()
  {
    return $this->_pubDate;
  }

  /**
   * Affects the date of publication
   * @param string $pubDate the date of publication
   */
  public function setPubDate($pubDate)
  {
    $this->_pubDate = $pubDate;
  }

  /**
   * Returns the template's topic
   * @return string the template's topic
   */
  public function getTopic()
  {
    return $this->_topic;
  }

  /**
   * Affects the template's topic
   * @param string $topic the template's topic
   */
  public function setTopic($topic)
  {
    $this->_topic = $topic;
  }

  /**
   * Returns the visibility of the template in the Workshop
   * @return boolean the visibility of the template in the Workshop
   */
  public function isPublic()
  {
    return $this->_public;
  }

  /**
   * Affects the visibility of the template in the Workshop
   * @param boolean $public the visibility of the template in the Workshop
   */
  public function setPublic($public)
  {
    $this->_public = $public;
  }

  /**
   * Returns the User (or ID) of the creator
   * @return User|int the User (or ID) of the creator
   */
  public function getUser()
  {
    return $this->_user;
  }

  /**
   * Affects the User (or ID) of the creator
   * @param User $user the User (or ID) of the creator
   */
  public function setUser($user)
  {
    $this->_user = $user;
  }

  /**
   * Returns the array of Tag associated with the template
   * @return array the array of Tag associated with the template
   */
  public function getTags()
  {
    return $this->_tags;
  }

  /**
   * Affects the array of Tag associated with the template
   * @param array $tags the array of Tag associated with the template
   */
  public function setTags($tags)
  {
    $this->_tags = $tags;
  }

  /**
   * Returns the array of Rate associated with the template
   * @return array the array of Rate associated with the template
   */
  public function getRates()
  {
    return $this->_rates;
  }

  /**
   * Affects  the array of Rate associated with the template
   * @param array $rates the array of Rate associated with the template
   */
  public function setRates($rates)
  {
    $this->_rates = $rates;
  }

  /**
   * Returns the array of Commentary associated with the template
   * @return array the array of Commentary associated with the template
   */
  public function getCommentaries()
  {
    return $this->_commentaries;
  }

  /**
   * Affects the array of Commentary associated with the template
   * @param array $commentaries the array of Commentary associated with the template
   */
  public function setCommentaries($commentaries)
  {
    $this->_commentaries = $commentaries;
  }
  
  /**
   * Returns the relative path of the template's preview
   * @return string the relative path of the template's preview
   */
  public function getPreview()
  {
	if ($this->_preview != null) {
	  return self::PREVIEW_PATH . $this->_preview;
	} else {
	  return null;
	}
  }

  /**
   * Affects the name of the template's preview image
   * @param string $path the name of the template's preview image
   */
  public function setPreview($path)
  {
    $this->_preview = $path;
  }

  ////////// METHODES UTILITAIRES //////////

  /**
   * Returns the average of template's rates.
   * @return int the average of template's rates.
   */
  public function getAvgRate()
  {
    $avg = 0;
    $nb = 0;
    if (!empty($this->getRates())) {
      foreach($this->getRates() as $rate) {
        $avg += $rate->getNbStar();
        $nb++;
      }
      $avg /= $nb;
    }
    return $avg;
  }

  /**
   * Returns a popularity index based on ratings and comments
   * @return float|int the popularity index based on ratings and comments
   */
  public function getPopularityCoeff()
  {
    $nbRates = count($this->getRates());
    $nbCommentaries = count($this->getCommentaries());
    $avg = $this->getAvgRate();
    return ($nbRates + $nbCommentaries) * $avg;
  }
}