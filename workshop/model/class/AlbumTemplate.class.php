<?php
require_once('../model/class/Template.class.php');

/**
 * Class AlbumTemplate
 * Grouping additional data specific to the templates of photo albums
 */
class AlbumTemplate extends Template
{
  /**
   * @var string the album template's format
   */
  private $_format;

  /**
   * @var string the album template's size
   */
  private $_size;

  /**
   * Hydration function
   * @param array $datas array of data retrieved from the database
   */
  protected function hydrate($datas)
  {
    parent::hydrate($datas);
    foreach ($datas as $key => $value) {
      switch ($key) {
        case 'at_format':
          $this->setFormat($value);
          break;
        case 'at_size':
          $this->setSize($value);
          break;
      }
    }
  }

  ////////// GETTERS & SETTERS //////////

  /**
   * Returns the album template's format
   * @return string the album template's format
   */
  public function getFormat()
  {
    return $this->_format;
  }

  /**
   * Affects the album template's format
   * @param string $format the album template's format
   */
  public function setFormat($format)
  {
    $this->_format = $format;
  }

  /**
   * Returns the album template's size
   * @return string the album template's size
   */
  public function getSize()
  {
    return $this->_size;
  }

  /**
   * Affects the album template's size
   * @param string $size the album template's size
   */
  public function setSize($size)
  {
    $this->_size = $size;
  }
}