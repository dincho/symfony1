<?php
if (!@constant('SF_ENVIRONMENT')) { // Only load constants in not done before (group tests)
    define('SF_APP', 'frontend');
    define('SF_ENVIRONMENT', 'test');
    define('SF_DEBUG', true);
}
 
if (!@constant('SF_ROOT_DIR')) { // Only load constants in not done before (group tests)
    include(dirname(__FILE__).'/unit.php');
}
 
sfCore::initSimpleAutoload(array(SF_ROOT_DIR.'/lib'
                                ,$sf_symfony_lib_dir // Symfony itself
                                ,dirname(__FILE__).'/../lib' // Location class to be tested
                                ,SF_ROOT_DIR.'/apps/frontend/lib' // Location myapp application
                                ,SF_ROOT_DIR.'/plugins',
                                )); // Location plugins
 
set_include_path($sf_symfony_lib_dir . '/vendor' . PATH_SEPARATOR . SF_ROOT_DIR . PATH_SEPARATOR . get_include_path());
 
/*
 * Start database connection and Symfony core
 */
sfCore::bootstrap($sf_symfony_lib_dir, $sf_symfony_data_dir);
sfContext::getInstance();
Propel::setConfiguration(sfPropelDatabase::getConfiguration());
Propel::initialize();