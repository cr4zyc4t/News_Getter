<?php
class Api_Model_Contents extends Zend_Db_Table_Abstract
{
	public $_name = 'news';
	protected $_primary = 'id';
	
	public function detail($id)
	{
		if (!isset($id)) {
			$id = -1;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql =$db->select()->from( $this->_name )->where("id=?", $id);
	  	return $db->fetchRow($sql);
	}
	
	public function setStatus($id, $status)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->query("UPDATE `$this->_name` SET `status`= $status WHERE `id`=$id");
	}
	
	public function playCount($id)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->query("UPDATE `$this->_name` SET `view`=`view`+1 WHERE `id`=$id");
	}
	
	public function getPageSource($id)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name)->where('id=?',$id);
		
		return $db->fetchAll($sql);
	}
	
	public function getListContent($subcategory_id = -1)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name, array("id", "created_time","title", "description", "icon","time"))->where('subcategory_id=?',$subcategory_id)->order("time desc");
		
		return $db->fetchAll($sql);
	}
	
	public function seachContent($keyword, $subcategory_id = -1)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT * FROM $this->_name WHERE `title` LIKE '%$keyword%' ";
		if ($subcategory != -1) {
			$sql.= " AND `subcategory_id` = $subcategory_id";
		}else{
			$sql.= " AND `subcategory_id` IN (32,33)";
		}
		
		return $db->fetchAll($sql);
	}
	
	public function getNewsDetail($id = -1, $isRead = TRUE){
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name))
					->joinLeft(array('s'	=> "source"), "n.source_id = s.id",array("source_icon"	=> "icon",'source_name'	=> 'title'))
					->where("n.id = ?", $id);
		$result = $db->fetchRow($mySql);
		
		if ($isRead) {
			$sql = "UPDATE `$this->_name` SET `view`=`view`+1 WHERE `id`=$id";
			$db->query($sql);
		}
		
		return $result;
	} 
}