<?php
class Model_NewsError extends Zend_Db_Table_Abstract
{
	public $_name = 'news_error';
	protected $_primary = 'id';
	
	public function add($url)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()->from($this->_name)->where("url = ?", $url);
		$result = $db->fetchRow($mySql);
		
		if (count($result) == 0) {
			$db->query("INSERT INTO `news_error`(`url`) VALUES ('$url')"); 
		}
	}
}