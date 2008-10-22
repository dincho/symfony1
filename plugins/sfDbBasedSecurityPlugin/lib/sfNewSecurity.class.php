<?php
class sfNewSecurity extends sfFilter
{
    public function execute ($filterChain) {
        // Test if the New Security Plugin is on
        $is_secure = sfConfig::get("app_new_sec_is_secure");
        if ($is_secure) {
            // If Security is on
            // get the cool stuff, LIKE THE BASIC
            $context = $this->getContext();
            $controller = $context->getController();
            $user = $context->getUser();
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $login_module = sfConfig::get('sf_login_module');
            $login_action = sfConfig::get('sf_login_action');
            $exec_login_action = sfConfig::get('sf_execute_login_action');
            $exec_logout_action = sfConfig::get('sf_execute_logout_action');
            $secure_module = sfConfig::get('sf_secure_module');
            $secure_action = sfConfig::get('sf_secure_action');
            
            // Disable for login page, login and logout execution and secure page
            if (
                   (
                    ($module == $login_module) &&
                    (($action == $login_action) || ($action == $exec_login_action) || ($action == $exec_logout_action))
                   )
                   ||
                   (
                    ($module == $secure_module) && ($action == $secure_action)
                   )
               ) {
                $filterChain->execute();
                return;
            }
            
            // Let's test the user / system security
            if (!$user->isAuthenticated()) {
                // the user is not authenticated
                $controller->forward(sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
                throw new sfStopException();
            } else {
                // the user IS authenticated
                $id = sfConfig::get("app_new_sec_id");
                $class = sfConfig::get("app_new_sec_class");
                $user_id = $user->getAttribute($id, null, "{$class}_sfNewSecurityPlugin");
                $is_superuser = $user->getAttribute('superuser', null, "{$class}_sfNewSecurityPlugin");
                $user_actions = sfNewSecurityQueries::getUserActions($user_id);
                
                if ($is_superuser || in_array("$module/$action", $user_actions)) {
                    $filterChain->execute();
                    return;
                } else {
                    $controller->forward($secure_module, $secure_action);
                    throw new sfStopException();
                }
            }
        } else {
            // If Security is off
            $filterChain->execute();
        }
    }
}