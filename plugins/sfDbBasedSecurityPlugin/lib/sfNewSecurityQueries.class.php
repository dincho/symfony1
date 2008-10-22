<?php
class sfNewSecurityQueries
{
    public static function getUserGroups($user_id) {
        $conn = Propel::getConnection();
        $table = strtolower(sfConfig::get("app_new_sec_class"));
        $sql = "SELECT group_id FROM permissions WHERE id = $user_id";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
        $groups = array();
        while ($result->next()) {
            $groups[] = $result->getInt("group_id");
        }
        return $groups;
    }
    
    public static function listUserGroups($user_id) {
        $array_groups = self::getUserGroups($user_id);
        $list = "";
        if (!empty($array_groups)) {
            $groups = implode(", ", $array_groups);
            $conn = Propel::getConnection();
            $sql = "SELECT id, group_name FROM groups WHERE id in (".$groups.")";
            $stmt = $conn->prepareStatement($sql);
            $result = $stmt->executeQuery();
            $list = array();
            while ($result->next())
                $list[$result->getString("id")] = $result->getString("group_name");
        }
            
        return $list;
    }
    
    public static function getUserActions($user_id) {
        $groups = self::getUserGroups($user_id);
        
        $criteria = new Criteria();
        $criteria->add(GroupAndActionPeer::GROUP_ID, $groups, Criteria::IN);
        $group_actions = GroupAndActionPeer::doSelect($criteria);
        $actions = array();
        foreach ($group_actions as $group_action) {
            $actions[] = $group_action->getAction();
        }
        
        return $actions;
    }
    
    public static function getUsers($user_name = null) {
        $conn = Propel::getConnection();
        $id = sfConfig::get("app_new_sec_id");
        $table = strtolower(sfConfig::get("app_new_sec_class"));
        $text = sfConfig::get("app_new_sec_text");
        $where = "";
        $names = "";
        foreach($text as $name) {
            $names .= "$name, ";
            if (!empty($user_name))
                $where .= "$name SIMILAR TO '%$user_name%' OR ";
        }
        $names = substr($names, 0, (strlen($names)-2));
        if (!empty($user_name))
            $where = substr($where, 0, (strlen($where)-4));
        $order_by = sfConfig::get("app_new_sec_order_by");
        $orders = "";
        foreach($order_by as $order)
            $orders .= "$order, ";
        $orders = substr($orders, 0, (strlen($orders)-2));
        if (!empty($user_name))
            $where = "WHERE $where";
        $sql = "SELECT $id, $names FROM $table $where ORDER BY $orders";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
        $users = array();
        while ($result->next()) {
            $name = "";
            foreach($text as $t)
                $name .= $result->getString($t)." ";
            $users[$result->getInt($id)] = $name;
        }
        return $users;
    }
    
    public static function getUser($user_id) {
        $conn = Propel::getConnection();
        $id = sfConfig::get("app_new_sec_id");
        $table = strtolower(sfConfig::get("app_new_sec_class"));
        $fields = sfConfig::get("app_new_sec_text");
        $names = "";
        foreach($fields as $field)
            $names .= "$field, ";
        $names = substr($names, 0, (strlen($names)-2));
        $sql = "SELECT $id, $names FROM $table WHERE $id = $user_id";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
        $user = array();
        $result->next();
        $name = "";
        foreach($fields as $field)
            $name .= $result->getString($field)." ";
        $user["id"] = $result->getInt($id);
        $user["name"] = $name;
        return $user;
    }
    
    public static function getUserIdByName($user_name) {
        
    }
    
    public static function addUserGroup($user_id, $groupid) {
        $conn = Propel::getConnection();
        $conn->begin();
        $sql = "INSERT INTO permissions (id, group_id)
                VALUES ($user_id, $group_id)";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
        $conn->commit();
    }
    
    public static function deleteAllUserGroups($user_id) {
        $conn = Propel::getConnection();
        $id = sfConfig::get("app_new_sec_id");
        $table = strtolower(sfConfig::get("app_new_sec_class"));
        $sql = "DELETE FROM permissions WHERE $id = $user_id";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
    }

    public static function getGroupActions($group_id) {
        $conn = Propel::getConnection();
        $sql = "SELECT action FROM group_action WHERE group_id = $group_id";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
        $actions = array();
        while($result->next())
            $actions[] = $result->getString("action");
            
        return $actions;
    }

    public static function getGroupIdByName($group_name) {
        $conn = Propel::getConnection();
        $sql = "SELECT id FROM groups WHERE group_name = '$group_name'";
        $stmt = $conn->prepareStatement($sql);
        $result = $stmt->executeQuery();
        $result->next();
        return $result->getInt("id");
    }
}