<?php
class prMySQLSessionStorage extends sfMySQLSessionStorage 
{
  /**
   * Writes session data.
   *
   * @param string A session ID
   * @param string A serialized chunk of session data
   *
   * @return boolean true, if the session was written, otherwise an exception is thrown
   *
   * @throws <b>sfDatabaseException</b> If the session data cannot be written
   */
  public function sessionWrite($id, &$data)
  {
    // get table/column
    $db_table    = $this->getParameterHolder()->get('db_table');
    $db_data_col = $this->getParameterHolder()->get('db_data_col', 'sess_data');
    $db_id_col   = $this->getParameterHolder()->get('db_id_col', 'sess_id');
    $db_time_col = $this->getParameterHolder()->get('db_time_col', 'sess_time');
    $db_user_id_col = $this->getParameterHolder()->get('db_user_id_col', 'user_id');

    $user_id = sfContext::getInstance()->getUser()->getId();
    
    // cleanup the session id and data, just in case
    $id   = mysql_real_escape_string($id, $this->resource);
    $data = mysql_real_escape_string($data, $this->resource);

    // delete the record associated with this id
    $sql = 'UPDATE '.$db_table.' ' .
           'SET '.$db_data_col.' = \''.$data.'\', ' .
           $db_user_id_col.' = \''.$user_id.'\', ' .
           $db_time_col.' = NOW() ' .
           'WHERE '.$db_id_col.' = \''.$id.'\'';

    //sfLogger::getInstance()->info('Session write SQL: ' . $sql);
    if (@mysql_query($sql, $this->resource))
    {
      return true;
    }

    // failed to write session data
    $error = 'MySQLSessionStorage cannot write session data for id "%s"';
    $error = sprintf($error, $id);

    throw new sfDatabaseException($error);
  }
}
