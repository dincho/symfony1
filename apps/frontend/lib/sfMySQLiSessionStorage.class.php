<?php
class sfMySQLiSessionStorage extends sfMySQLSessionStorage
{
  public function sessionDestroy($id)
  {
    // get table/column
    $db_table  = $this->getParameterHolder()->get('db_table');
    $db_id_col = $this->getParameterHolder()->get('db_id_col', 'sess_id');

    // cleanup the session id, just in case
    $id = mysqli_real_escape_string($this->resource, $id);

    // delete the record associated with this id
    $sql = 'DELETE FROM '.$db_table.' WHERE '.$db_id_col.' = \''.$id.'\'';

    if (@mysqli_query($this->resource, $sql))
    {
      return true;
    }

    // failed to destroy session
    $error = 'MySQLSessionStorage cannot destroy session id "%s"';
    $error = sprintf($error, $id);

    throw new sfDatabaseException($error);
  }
      
  public function sessionGC($lifetime)
  {
    // get table/column
    $db_table    = $this->getParameterHolder()->get('db_table');
    $db_time_col = $this->getParameterHolder()->get('db_time_col', 'sess_time');

    $time = time() - $lifetime;

    // delete the record associated with this id
    $sql = 'DELETE FROM '.$db_table.' WHERE '.$db_time_col.' < '.$time;

    if (@mysqli_query($this->resource, $sql))
    {
      return true;
    }

    // failed to cleanup old sessions
    $error = 'MySQLSessionStorage cannot delete old sessions';

    throw new sfDatabaseException($error);
  }
      
  public function sessionRead($id)
  {
    // get table/column
    $db_table    = $this->getParameterHolder()->get('db_table');
    $db_data_col = $this->getParameterHolder()->get('db_data_col', 'sess_data');
    $db_id_col   = $this->getParameterHolder()->get('db_id_col', 'sess_id');
    $db_time_col = $this->getParameterHolder()->get('db_time_col', 'sess_time');

    // cleanup the session id, just in case
    $id = mysqli_real_escape_string($this->resource, $id);

    // delete the record associated with this id
    $sql = 'SELECT '.$db_data_col.' ' .
           'FROM '.$db_table.' ' .
           'WHERE '.$db_id_col.' = \''.$id.'\'';

    $result = @mysqli_query($this->resource, $sql);

    if ($result != false && @mysqli_num_rows($result) == 1)
    {
      // found the session
      $data = mysqli_fetch_row($result);

      return $data[0];
    }
    else
    {
      // session does not exist, create it
      $sql = 'INSERT INTO '.$db_table.' ('.$db_id_col.', ' .
             $db_data_col.', '.$db_time_col.') VALUES (' .
             '\''.$id.'\', \'\', NOW())';

      if (@mysqli_query($this->resource, $sql))
      {
        return '';
      }

      // can't create record
      $error = 'MySQLSessionStorage cannot create new record for id "%s"';
      $error = sprintf($error, $id);

      throw new sfDatabaseException($error);
    }
  }

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
    $id   = mysqli_real_escape_string($this->resource, $id);
    $data = mysqli_real_escape_string($this->resource, $data);

    // delete the record associated with this id
    $sql = 'UPDATE '.$db_table.' ' .
         'SET '.$db_data_col.' = \''.$data.'\', ' .
         $db_user_id_col.' = \''.$user_id.'\', ' .
         $db_time_col.' = '.time().' ' .
         'WHERE '.$db_id_col.' = \''.$id.'\'';

    if (@mysqli_query($this->resource, $sql))
    {
      return true;
    }

    // failed to write session data
    $error = 'MySQLSessionStorage cannot write session data for id "%s"';
    $error = sprintf($error, $id);

    throw new sfDatabaseException($error);
  }     
}