<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 28, 2009 1:01:20 PM
 * 
 */

class CustomQueryResultSet
{
    
    private $columns;
    private $queryColumns;
    private $resultSet;

    public function __construct($callerObject = false, $className = false, $peerClassName = false)
    {
        if (is_object($callerObject) && ! empty($className) && ! empty($peerClassName))
        {
            $fieldConstants = call_user_func(array($peerClassName, 'getFieldNames'), BasePeer::TYPE_FIELDNAME);
            $phpConstants = call_user_func(array($peerClassName, 'getFieldNames'), BasePeer::TYPE_PHPNAME);
            foreach ($callerObject as $key => $object)
            {
                if (1 === $key)
                {
                    $this->queryColumns = array_keys($object);
                    $this->columns = array_merge($phpConstants, array_diff($this->queryColumns, $fieldConstants));
                }
                $this->populateCustomObject($object, $key, $className);
            }
        } elseif (is_object($callerObject) && empty($className) && empty($peerClassName))
        {
            foreach ($callerObject as $key => $object)
            {
                if (1 === $key)
                {
                    $this->queryColumns = array_keys($object);
                    foreach ($this->queryColumns as $name)
                    {
                        $this->columns[] = sfInflector::camelize($name);
                    }
                }
                $this->populateCustomObject($object, $key, "CustomQuery");
            }
        
        } else
        {
            throw new sfException("You lost the object");
        }
    }

    private function populateCustomObject($callerObject, $key, $className)
    {
        $customObject = new CustomObject($className);
        foreach ($this->queryColumns as $ckey => $columnName)
        {
            $methodName = "set" . ucfirst($this->columns[$ckey]);
            $customObject->{$methodName}($callerObject[$columnName]);
        }
        $this->resultSet[$key - 1] = $customObject;
    }

    public function getResultSet()
    {
        return $this->resultSet;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}

