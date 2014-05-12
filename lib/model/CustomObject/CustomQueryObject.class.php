<?php
/**
 *
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 28, 2009 1:02:17 PM
 *
 */

class CustomQueryObject
{

    private $className;
    private $peerClassName;
    private $module;
    private $properties;
    private $caller;
    private $resultSet;
    private $customized = false;

    public function __construct($callerClassName = false)
    {
        if (class_exists($callerClassName)) {
            $this->caller = new $callerClassName();
            $this->setClass($callerClassName);
            $this->setPeerClass($callerClassName);
        } elseif (false === $callerClassName) {
            $this->customized = true;
        }
    }

    public function __call($funcname, $args = array())
    {
        if (false === $this->isCustomized() && is_object($this->caller) && function_exists('call_user_func_array')) {
            $this->caller = call_user_func_array(array(&$this->caller, $funcname), $args);
            $resultSet = new CustomQueryResultSet($this->caller, $this->getClass(), $this->getPeerClass());

            return $resultSet->getResultSet();
        } else {
            throw new sfException("Call to Function with call_user_func_array failed");
        }
    }

    protected function isCustomized()
    {
        return $this->customized;
    }

    public function query($query)
    {
        $connection = Propel::getConnection();
        $statement = $connection->createStatement();
        $this->caller = $statement->executeQuery($query);
        $resultSet = new CustomQueryResultSet($this->caller);

        return $resultSet->getResultSet();
    }

    public function prepare($query, $parameters = array())
    {
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        if (! empty($parameters)) {
            $increment = 1;
            foreach ($parameters as $parameter) {
                foreach ($parameter as $type => $value) {
                    switch ($type) {
                        case "int":
                        case "integer":
                            $statement->setInt($increment, $value);
                            break;
                        case "str":
                        case "string":
                            $statement->setString($increment, $value);
                            break;
                        case "decimal":
                        case "float":
                            $statement->setFloat($increment, $value);
                            break;
                        case "bool":
                        case "boolean":
                            $statement->setBoolean($increment, $value);
                            break;
                        case "blob":
                            $statement->setBlob($increment, $value);
                            break;
                        case "cblob":
                            $statement->setClob($increment, $value);
                            break;
                        case "date":
                            $statement->setDate($increment, $value);
                            break;
                        case "time":
                            $statement->setTime($increment, $value);
                            break;
                        case "timestamp":
                            $statement->setTimestamp($increment, $value);
                            break;
                        case "array":
                            $statement->setArray($increment, $value);
                            break;
                        case "NULL":
                        case "null":
                            $statement->setNull($increment, $value);
                            break;
                        case "double":
                            $statement->setDouble($increment, $value);
                            break;
                    }
                    $increment ++;
                }
            }

        }
        $this->caller = $statement->executeQuery();
        $resultSet = new CustomQueryResultSet($this->caller);

        return $resultSet->getResultSet();
    }

    public function getColumns()
    {
        return $this->resultSetColumns;
    }

    public function getPeerClass()
    {
        return $this->peerClassName;
    }

    public function setPeerClass($name)
    {
        $this->peerClassName = $name . "Peer";
    }

    public function getClass()
    {
        return $this->className;
    }

    public function setClass($name)
    {
        $this->className = $name;
    }
}
