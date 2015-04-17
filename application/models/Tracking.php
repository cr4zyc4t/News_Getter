<?php
// define('MONGODB_USERNAME', 'content_admin');
// define('MONGODB_PASSWORD', 'toanvq2014');
// define('MONGODB_HOST', '127.0.0.1');
// define('MONGODB_PORT', '27017');
// define('MONGODB_DATABASE', 'cms');

class Model_Tracking extends Shanty_Mongo_Document
{
	protected static $_db = 'cms';
  	protected static $_collection = 'tracking';
  	protected static $_requirements = array();
	
	// public function __construct(){
		// $connection = new Shanty_Mongo_Connection('mongodb://'.MONGODB_USERNAME.':'.MONGODB_PASSWORD.'@'.MONGODB_HOST.':'.MONGODB_PORT.'/'.MONGODB_DATABASE);
		// Shanty_Mongo::addMaster($connection);
	// }


    function daily(){
        $this->fetchAll(array(

        ));
    }
}