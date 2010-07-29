<?php

/**
 * sfMessageSource_pdMySQL class file.
 *
 *
 * @author     Dincho Todorov <dincho@xbuv.com>
 * @package    pr
 * @subpackage i18n
 */

class sfMessageSource_pdMySQL extends sfMessageSource_MySQL
{
  
  private $domain;
  
  function __construct($source)
  {
    parent::__construct($source);
    
    $domain = (isset($_SERVER['HTTP_HOST'])) ? strtolower($_SERVER['HTTP_HOST']) : 'localhost';
    $this->domain = sfConfig::get('app_catalog_domains_' . $domain, $domain);
  }
  
  /**
   * Gets an array of messages for a particular catalogue and cultural variant.
   *
   * @param string the catalogue name + variant
   * @return array translation messages.
   */
  protected function &loadData($variant)
  {

    $variant = mysql_real_escape_string($variant, $this->db);
    $domain = mysql_real_escape_string($this->domain, $this->db);
    
    $statement =
      "SELECT t.id, t.source, t.target, t.comments
        FROM trans_unit t, catalogue c
        WHERE c.cat_id =  t.cat_id
          AND c.name = '{$variant}'
          AND c.domain = '{$domain}'
        ORDER BY id ASC";

    $rs = mysql_query($statement, $this->db);

    $result = array();

    while ($row = mysql_fetch_array($rs, MYSQL_NUM))
    {
      $source = $row[1];
      $result[$source][] = $row[2]; //target
      $result[$source][] = $row[0]; //id
      $result[$source][] = $row[3]; //comments
    }

    return $result;
  }

  /**
   * Gets the last modified unix-time for this particular catalogue+variant.
   * We need to query the database to get the date_modified.
   *
   * @param string catalogue+variant
   * @return int last modified in unix-time format.
   */
  protected function getLastModified($source)
  {
    $source = mysql_real_escape_string($source, $this->db);
    $domain = mysql_real_escape_string($this->domain, $this->db);
    
    $rs = mysql_query("SELECT date_modified FROM catalogue WHERE name = '{$source}' AND domain = '{$domain}'", $this->db);

    $result = $rs ? intval(mysql_result($rs, 0)) : 0;

    return $result;
  }

  /**
   * Checks if a particular catalogue+variant exists in the database.
   *
   * @param string catalogue+variant
   * @return boolean true if the catalogue+variant is in the database, false otherwise.
   */ 
  protected function isValidSource($variant)
  {
    $variant = mysql_real_escape_string ($variant, $this->db);
    $domain = mysql_real_escape_string($this->domain, $this->db);
    
    $rs = mysql_query("SELECT COUNT(*) FROM catalogue WHERE name = '{$variant}' AND domain = '{$domain}'", $this->db);

    $row = mysql_fetch_array($rs, MYSQL_NUM);

    $result = $row && $row[0] == '1';

    return $result;
  }

  /**
   * Retrieves catalogue details, array($cat_id, $variant, $count).
   *
   * @param string catalogue
   * @return array catalogue details, array($cat_id, $variant, $count). 
   */
  protected function getCatalogueDetails($catalogue = 'messages')
  {
    if (empty($catalogue))
    {
      $catalogue = 'messages';
    }

    $variant = $catalogue.'.'.$this->culture;

    $name = mysql_real_escape_string($this->getSource($variant), $this->db);
    $domain = mysql_real_escape_string($this->domain, $this->db);
    
    $rs = mysql_query("SELECT cat_id FROM catalogue WHERE name = '{$name}' AND domain = '{$domain}'", $this->db);

    if (mysql_num_rows($rs) != 1)
    {
      return false;
    }

    $cat_id = intval(mysql_result($rs, 0));

    // first get the catalogue ID
    $rs = mysql_query("SELECT COUNT(*) FROM trans_unit WHERE cat_id = {$cat_id}", $this->db);

    $count = intval(mysql_result($rs, 0));

    return array($cat_id, $variant, $count);
  }

  /**
   * Returns a list of catalogue as key and all it variants as value.
   *
   * @return array list of catalogues 
   */
  function catalogues()
  {
    $domain = mysql_real_escape_string($this->domain, $this->db);
    
    $statement = "SELECT name FROM catalogue WHERE domain = '{$domain}' ORDER BY name";
    $rs = mysql_query($statement, $this->db);
    $result = array();
    while($row = mysql_fetch_array($rs, MYSQL_NUM))
    {
      $details = explode('.', $row[0]);
      if (!isset($details[1]))
      {
        $details[1] = null;
      }

      $result[] = $details;
    }

    return $result;
  }
  
  function __destruct()
  {
      //do nothing, the parent closes the mysql connection, but we don't want so.
  }  
}
