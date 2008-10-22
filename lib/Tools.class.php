<?php
class Tools
{

    public static function getMimeType($file)
    {
        //copy file to other dir do not work for some reason, symlink works
        //$magic_mime = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'magic';
        $magic_mime = '/usr/share/file/magic';
        if (! function_exists('finfo_open'))
            throw new Exception(__METHOD__ . " require PECL fileinfo installed.");
        if (! file_exists($magic_mime) || ! is_readable($magic_mime))
        {
            throw new Exception(__METHOD__ . ' unable to read magic mime file: ' . $magic_mime);
        }
        $finfo = finfo_open(FILEINFO_MIME, $magic_mime);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);
        return $mime;
    }

    public static function Mime2Ext($mime)
    {
        $mimeTypes = unserialize(file_get_contents(sfConfig::get('sf_symfony_data_dir') . '/data/mime_types.dat'));
        return isset($mimeTypes[$mime]) ? '.' . $mimeTypes[$mime] : '.bin';
    }

    public static function generateString($length = 8)
    {
        $sting = "";
        // define possible characters
        $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDFGHJKMNPQRSTVWXYZ";
        $i = 0;
        while ($i < $length)
        {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            // we don't want this character if it's already in the string
            if (! strstr($sting, $char))
            {
                $sting .= $char;
                $i ++;
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
        if( $plain ) $text = strip_tags($text);
        if (strlen($text) > $numb)
        {
            $text = substr($text, 0, $numb);
            if (strrpos($text, " "))
                $text = substr($text, 0, strrpos($text, " "));
            $text = $text . $etc;
        }
        if( $plain) $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        return $text;
    }

    public static function br2nl($text)
    {
        return preg_replace('/<br\\s*?\/??>/i', "\n", $text);
    }

    public static function createThumbnails($obj)
    {
        foreach ($obj->getThumbSizes() as $thumbSize)
        {
            $thumbnail = new sfThumbnail($thumbSize['width'], $thumbSize['height']);
            $thumbnail->loadFile($obj->getImagePath());
            $thumbDir = $obj->getImagesPath() . $thumbSize['width'] . 'x' . $thumbSize['height'] . DIRECTORY_SEPARATOR;
            if (! file_exists($thumbDir))
                mkdir($thumbDir, 0777, true);
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
}
?>