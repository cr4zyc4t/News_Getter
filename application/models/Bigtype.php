<?php
class Model_Bigtype extends Zend_Db_Table_Abstract
{
	public $_name = 'type';
	protected $_primary = 'id';
	
	public function detail($id = -1)
	{
		if (!$id) {
			$id = -1;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql =$db->select()->from( $this->_name )->where("id=?", $id);
	  	return $db->fetchRow($sql);
	}
	
	public function getById($id)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name)
				  ->where('id = ?',$id);
	  	return $db->fetchRow($sql);
	}
	
	public function getAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name);
	  	return $db->fetchAll($sql);
	}
	
	public function tableData()
	{
		$headers = array("Title", "Created Time","Control");
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name);
	  	$result = $db->fetchAll($sql);
		
		$rows = array();
		foreach ($result as $key => $value) {
			$action = "<a href=\"/admin/resource/addtype?id=$value[id]\" class=\"\" >Edit</a>";
			$action.= " | <a href=\"/admin/resource/deletetype?id=$value[id]\" class=\"deleteRowBtn\" >Delete</a>";
			
			$row = array();
			$row[] = $value['title'];
			$row[] = $value['created_time'];
			$row[] = $action;
			
			$rows[] = $row;
		}
		return array('headers' => $headers, 'rows' => $rows);
	}
}