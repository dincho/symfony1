<?php
/**
 *
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 28, 2009 1:00:17 PM
 *
 */

class CustomObject
{

    private $objectName;

    public function __construct($name)
    {
        $this->objectName = $name;
    }

    public function getObjectName()
    {
        return $this->objectName();
    }

    public function __call($funcname, $args = array())
    {
        if (! function_exists($funcname)) {
            $method = substr($funcname, 3);
            $methodType = substr($funcname, 0, 3);
            switch ($methodType) {
                case "set":
                    $this->{$method} = $args[0];
                    break;
                case "get":
                    return $this->{$method};
                    break;
            }

        } else {
            throw new sfException("Call to Function with call_user_func_array failed");
        }
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

}
