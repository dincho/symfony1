<?php
//this file is only for include purpose
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) exit();

class Subscribe
{
    private $con = null;
    private $mysql = array('server' => 'localhost', 'username' => 'prcs', 'password' => 'promance', 'dbname' => 'prcs', 'table' => 'prcs');
    private $debug = false;
    private $error = null;

    public function __construct()
    {
    }

    /*
   * @return bool
   */
    public function validate_email($email = '')
    {
        $re = '/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i';
        if (! preg_match($re, $email))
        {
            return false;
        }
        if (function_exists('checkdnsrr'))
        {
            $tokens = explode('@', $email);
            if (! checkdnsrr($tokens[1], 'MX') && ! checkdnsrr($tokens[1], 'A'))
            {
                return false;
            }
        }
        return true;
    }

    /*
   * @return bool
   */
    public function add($email = '')
    {
        if (! $this->validate_email($email))
        {
            $this->error = 'Invalid email address';
            return false;
        }
        //escape the email, just for sure
        $email = mysql_real_escape_string($email, $this->getConnection());
        $query = "INSERT INTO `" . $this->mysql['table'] . "` ( `id` , `email` ) VALUES (NULL , '" . $email . "')";
        $ret = mysql_query($query, $this->con);
        
        if ($ret) return true;
        if (mysql_errno() == 1062)
        {
            $this->error = 'You are already subscribed.';
        } elseif ($this->debug)
        {
            die('Could not execute mysql query: ' . $query . "<br />\n" . mysql_error() . "<br />\nError No:" . mysql_errno());
        }
        return false;
    }

    public function hasError()
    {
        return (is_null($this->error)) ? false : true;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getConnection()
    {
        if (is_null($this->con))
        {
            $this->con = mysql_connect($this->mysql['server'], $this->mysql['username'], $this->mysql['password']);
            if ($this->debug && ! $this->con)
                die('Could not connect to mysql server: ' . mysql_error());
            $db_select = mysql_select_db($this->mysql['dbname'], $this->getConnection());
            if ($this->debug && ! $db_select)
                die('Could not select mysql database: ' . mysql_error());
        }
        return $this->con;
    }

    public function __destruct()
    {
        if (is_resource($this->getConnection()))
        {
            mysql_close($this->getConnection());
        }
    }
}
?>