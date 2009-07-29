<?php
class Tools
{

    public static function generateString($length = 8)
    {
        $sting = "";
        // define possible characters
        $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDFGHJKMNPQRSTVWXYZ";
        $i = 0;
        while($i < $length)
        {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            // we don't want this character if it's already in the string
            if(!strstr($sting, $char))
            {
                $sting .= $char;
                $i++;
            }
        }
        return $sting;
    }

    public static function escapeFileName($FileName)
    {
        return preg_replace('#[^\w_]#', '_', $FileName);
    }

    public static function truncate($text, $numb, $etc = '...', $plain = true)
    {
        $text = html_entity_decode($text, ENT_QUOTES);
        if($plain) $text = strip_tags($text);
        if(strlen($text) > $numb)
        {
            $text = substr($text, 0, $numb);
            if(strrpos($text, " ")) $text = substr($text, 0, strrpos($text, " "));
            $text = $text . $etc;
        }
        if($plain) $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        return $text;
    }

    public static function br2nl($text)
    {
        return preg_replace('/<br\\s*?\/??>/i', "\n", $text);
    }

    public static function createThumbnails($obj)
    {
        foreach($obj->getThumbSizes() as $thumbSize)
        {
            $thumbnail = new sfThumbnail($thumbSize ['width'], $thumbSize ['height']);
            $thumbnail->loadFile($obj->getImagePath());
            $thumbDir = $obj->getImagesPath() . $thumbSize ['width'] . 'x' . $thumbSize ['height'] . DIRECTORY_SEPARATOR;
            if(!file_exists($thumbDir)) mkdir($thumbDir, 0777, true);
            $thumbFIle = $thumbDir . $obj->getImage();
            $thumbnail->save($thumbFIle);
            chmod($thumbFIle, 0666);
        }
    }

    public static function randomTimestamp($time1 = "1 January 2000", $time2 = "30 May 2008")
    {
        srand((float) microtime() * 10000000);
        $time1 = strtotime($time1);
        $time2 = strtotime($time2);
        $timestamp = rand($time1, $time2);
        return $timestamp;
    }

    public static function getStringRequestParameterAsArray($name)
    {
        return array_map('trim', explode(',', sfContext::getInstance()->getRequest()->getParameter($name)));
    }

    /* IP conversions/checks */
    public static function cdrtobin($cdrin)
    {
        return str_pad(str_pad("", $cdrin, "1"), 32, "0");
    }

    public static function bintodq($binin)
    {
        $binin = explode(".", chunk_split($binin, 8, "."));
        for($i = 0; $i < 4; $i++)
        {
            $dq [$i] = bindec($binin [$i]);
        }
        return implode(".", $dq);
    }

    public static function short_mask_to_long($m)
    {
        return self::bintodq(self::cdrtobin($m));
    }

    public static function ip2host($ip)
    {
        return gethostbyaddr($ip);
    }

    public static function isValidEmail($email)
    {
        if(eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email))
        {
            return true;
        } else
        {
            return false;
        }
    }

    public static function isValidIp($ip)
    {
        return ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}$', $ip);
    }

    public static function slugify($text)
    {
        // replace all non words to _ ( Unicode save )
        $text = preg_replace('/[^\p{L}]+/u', '_', $text);

        $text = trim($text, '_');

        return $text;
    }
    
    public static function getAgeFromDateString($date = null)
    {
        if( is_null($date) ) return null;
        
        list($b_Y, $b_m, $b_d) = explode('-', $date);
        list($now_Y, $now_m, $now_d) = explode('-', date('Y-m-d', time()));
        $age = $now_Y - $b_Y - 1;
        
        if( $now_m > $b_m || ( $now_m == $b_m && $now_d >= $b_d) ) 
        {
            $age++;
        }
        
        return $age;
    }

}
?>