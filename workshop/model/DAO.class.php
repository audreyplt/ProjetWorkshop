<?php
/**
 * Class DAO
 * The manager between PHP and MySQL
 */
class DAO
{
  /**
   * string the table that gathers the data exclusive to album templates
   */
  const ALBUM_TEMPLATE = 'pw_album_template';
  // TO COMPLETE...

  /**
   * @var array specialized tables for each type of template
   */
  public static $_templatesTables = array(
    self::ALBUM_TEMPLATE,
    // TO COMPLETE...
  );

  /**
   * the unique id of the anonymous user. It is the one that collects orphaned templates when a user with public templates is deleted from the Workshop.
   */
  const ANONYMOUS_ID = 2;

  /**
   * @var PDO the unique PDO instance
   */
  private static $_db;

  /**
   * Returns the unique PDO instance
   * @return PDO the unique PDO instance
   */
  public static function getDB()
  {
    if (!isset(self::$_db) || self::$_db == NULL) {
      try {
        $config = parse_ini_file('../config/config.ini', true);
        $databaseLocation = 'mysql:host=' . $config['database_host'] . ';dbname=' . $config['database_name'];
        self::$_db = new PDO($databaseLocation, $config['database_login'], $config['database_passwd']);
        self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$_db->exec('SET CHARACTER SET utf8');
      } catch (Exception $e) {
        die('Exception DAO.class : ' . $e->getMessage());
      }
    }
    return self::$_db;
  }
}
