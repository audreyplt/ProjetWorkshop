<?php
/**
 * Class Badge
 * Visual elements that can be retrieved by users by meeting certain conditions.
 */
class Badge
{
  /**
   * @var int the badge's id
   */
  private $_id;

  /**
   * @var string the badge's name
   */
  private $_name;

  /**
   * @var string the condition to get the badge
   */
  private $_description;

  /**
   * @var string the date obtained (only if the instance is associated with a user)
   */
  private $_dateObtained;

  /**
   * Badge constructor.
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
        case 'b_id':
          $this->setId($value);
        case 'b_name':
          $this->setName($value);
          break;
        case 'b_description':
          $this->setDescription($value);
          break;
        case 'date_obtention':
          $this->setDateObtained($value);
          break;
      }
    }
  }

  /**
   * Returns the badge's id
   * @return int the badge's id
   */
  public function getId()
  {
    return $this->_id;
  }

  /**
   * Affects the badge's id
   * @param int $id the badge's id
   */
  public function setId($id)
  {
    $this->_id = $id;
  }

  /**
   * Returns the badge's name
   * @return string the badge's name
   */
  public function getName()
  {
    return $this->_name;
  }

  /**
   * Affects the badge's name
   * @param string $name the badge's name
   */
  public function setName($name)
  {
    $this->_name = $name;
  }

  /**
   * Returns the condition to get the badge
   * @return string the condition to get the badge
   */
  public function getDescription()
  {
    return $this->_description;
  }

  /**
   * Affects the condition to get the badge
   * @param string $description the condition to get the badge
   */
  public function setDescription($description)
  {
    $this->_description = $description;
  }

  /**
   * Returns the date obtained
   * @return string the date obtained
   */
  public function getDateObtained()
  {
    return $this->_dateObtained;
  }

  /**
   * Affects the date obtained
   * @param string $dateObtained the date obtained
   */
  public function setDateObtained($dateObtained)
  {
    $this->_dateObtained = $dateObtained;
  }
}