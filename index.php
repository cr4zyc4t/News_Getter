<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'development');
    
// Define path to public folder
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__)). '/assets');
    
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),    
    realpath(APPLICATION_PATH . '/modules'),
    get_include_path()
)));

require_once 'Zend/Application.php' ;
$application = new Zend_Application( 
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini' 
); 
$application->bootstrap()->run();