<?php
class Model_Tag extends Zend_Db_Table_Abstract
{
	public $_name = 'tags';
	protected $_primary = 'id';
	protected $db = null;
	
	// public function __construct()
	// {
		// $this->db = Zend_Db_Table::getDefaultAdapter();
	// }
	
	public function save($data, $unique = null)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		if (is_array($data) ) {
			unset($data['created_time']);
			
			if ($unique != null) {
				$check = new Zend_Validate_Db_NoRecordExists(array("table"=> $this->_name,'field'=>$unique));
				if(!$check->isValid($data[$unique])){
					return 0;
				}
			}
			
			if (isset($data['id']) && is_numeric($data['id'])) {
				$id = $data['id'];
				unset($data['id']);
				
				$db->update($data,"id=$id");
				return $id;
			}else{
				return $db->insert($data);
			}
		}
		return 0;
	}
	
	public function detail($id = -1)
	{
		if (!$id) {
			$id = -1;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from( $this->_name )->where("id=?", $id);
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