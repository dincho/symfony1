<?php
class tools {

    public static function validEmail($email)
    {
	if (eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email))
	{
	    return true;
	}
	else
	{
	    return false;
	}
    }
   
    public static function ip_valid($ip)
    {
	return ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}$', $ip)       ;
    }

}
																	

