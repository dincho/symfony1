<?php
class sfDirectoryActions
{
    public static function listDirs($dir) {
        $dirs = array();
        
        // sfNewSecurityPlugin's Modules
        $groups_module = "sfNewSecurityGroups";
        $perms_module = "sfNewSecurityPermissions";
        $dirs[$groups_module] = array (
                                        "$groups_module/index"  =>  "index",
                                        "$groups_module/show"   =>  "show",
                                        "$groups_module/create" =>  "create",
                                        "$groups_module/new"    =>  "new",
                                        "$groups_module/edit"   =>  "edit",
                                        "$groups_module/update" =>  "update",
                                        "$groups_module/delete" =>  "delete"
                                      );
        $dirs[$perms_module] = array (
                                        "$perms_module/index"   =>  "index",
                                        "$perms_module/edit"    =>  "edit",
                                        "$perms_module/update"  =>  "update"
                                      );
        
        // App's Modules
        if (is_dir($dir)) {
            if ($handler = opendir($dir)) {
                 while (($file = readdir($handler)) !== false) {
                     if (is_dir("$dir/$file") && $file !== "." && $file !== ".." && $file !== '.svn')
                        $dirs[$file] = self::listActions($dir, $file);
                 }
            } else {
                throw new Exception("Could not open the directory.");
            }
        } else {
            throw new Exception("The path is not a directory.");
        }
        
        return $dirs;
    }
    
    public static function listActions($dir, $module) {
        $actions = array();
        
        include "$dir/$module/actions/actions.class.php";
        $class = new ReflectionClass("{$module}Actions");
        $methods = $class->getMethods();
        foreach ($methods as $method)
            if (preg_match("/^execute([a-zA-Z]+)$/i", $method->getName(), $matches)) {
                $action = strtolower($matches[1]);
                $actions["$module/$action"] = $action;
            }
        
        $otherActions = self::listOtherActions($dir, $module);
        if (!empty($otherActions))
            $actions = array_merge($actions, $otherActions);
        
        return $actions;
    }
    
    private static function listOtherActions($dir, $module) {
        $actions = array();
        
        $path = "$dir/$module/actions";
        if (is_dir($path)) {
            if ($handler = opendir($path)) {
                while (($file = readdir($handler)) !== false) {
                    if (preg_match("/^([a-zA-Z]+)Action\.class\.php$/i", $file, $matches)) {
                        $action = strtolower($matches[1]);
                        $actions["$module/$action"] = $action;
                    }
                }
            }
        }
        
        return $actions;
    }
}