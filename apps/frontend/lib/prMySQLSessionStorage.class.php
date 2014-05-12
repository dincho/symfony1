<?php
class prMySQLSessionStorage extends sfMySQLSessionStorage
{
    public function initialize($context, $parameters = null)
    {
        // disable auto_start
        $parameters['auto_start'] = false;

        $this->context = $context;

        $this->parameterHolder = new sfParameterHolder();
        $this->getParameterHolder()->add($parameters);

        // set session name
        $sessionName = $this->getParameterHolder()->get('session_name', 'symfony');

        session_name($sessionName);

        $sessionId = $context->getRequest()->getParameter($sessionName, '');
        if ($sessionId != '') {
            session_id($sessionId);
        }

        $cookieDefaults = session_get_cookie_params();
        $lifetime = $this->getParameter('session_cookie_lifetime', $cookieDefaults['lifetime']);
        $path     = $this->getParameter('session_cookie_path',     $cookieDefaults['path']);
        $domain   = $this->getParameter('session_cookie_domain',   $cookieDefaults['domain']);
        $secure   = $this->getParameter('session_cookie_secure',   $cookieDefaults['secure']);
        $httpOnly = $this->getParameter('session_cookie_httponly', isset($cookieDefaults['httponly']) ? $cookieDefaults['httponly'] : false);
        if (version_compare(phpversion(), '5.2', '>=')) {
          session_set_cookie_params($lifetime, $path, $domain, $secure, $httpOnly);
        } else {
          session_set_cookie_params($lifetime, $path, $domain, $secure);
        }

        if (!$this->getParameterHolder()->has('db_table')) {
            // missing required 'db_table' parameter
            $error = 'Factory configuration file is missing required "db_table" parameter for the Storage category';

            throw new sfInitializationException($error);
        }

        // use this object as the session handler
        session_set_save_handler(array($this, 'sessionOpen'),
                                 array($this, 'sessionClose'),
                                 array($this, 'sessionRead'),
                                 array($this, 'sessionWrite'),
                                 array($this, 'sessionDestroy'),
                                 array($this, 'sessionGC'));

        // start our session
        session_start();
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
    if (!$user_id) {
      $user_id = "NULL"; //SQL NULL
    }

    // cleanup the session id and data, just in case
    $id   = mysql_real_escape_string($id, $this->resource);
    $data = mysql_real_escape_string($data, $this->resource);

    // delete the record associated with this id
    $sql = 'UPDATE '.$db_table.' ' .
           'SET '.$db_data_col.' = \''.$data.'\', ' .
           $db_user_id_col.' = '.$user_id.', ' .
           $db_time_col.' = NOW() ' .
           'WHERE '.$db_id_col.' = \''.$id.'\'';

    //sfLogger::getInstance()->info('Session write SQL: ' . $sql);
    if (@mysql_query($sql, $this->resource)) {
      return true;
    }

    // failed to write session data
    $error = 'MySQLSessionStorage cannot write session data for id "%s"';
    $error = sprintf($error, $id);

    throw new sfDatabaseException($error);
  }

  public function sessionGC($lifetime)
  {
    // get table/column
    $db_table    = $this->getParameterHolder()->get('db_table');
    $db_time_col = $this->getParameterHolder()->get('db_time_col', 'sess_time');

    // delete the record associated with this id
    $date = new DateTime();
    $date->sub(new DateInterval(sprintf('PT%dS', $lifetime)));
    $mysql_date = date("Y-m-d H:i:s", $date->getTimestamp());

    $sql = 'DELETE FROM '.$db_table.' '.
           'WHERE '.$db_time_col.' < "' .$mysql_date.'"';

    if (@mysql_query($sql, $this->resource)) {
      return true;
    }

    // failed to cleanup old sessions
    $error = 'MySQLSessionStorage cannot delete old sessions';

    throw new sfDatabaseException($error);
  }
}
