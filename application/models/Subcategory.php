<?php
class Model_Subcategory extends Zend_Db_Table_Abstract
{
	public $_name = 'sub_category';
	protected $_primary = 'id';

	public function getByTitle($title){
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
			->from($this->_name)
			->where('title = ?',$title);
		return $db->fetchRow($sql);
	}
	
	public function getListSubCtg($category_id)
	{
		$list = array();
		$db = $this->getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name, array("id"))
				  ->where('category_id = ?',$category_id)
				  ->order("sort asc");
	  	foreach ($db->fetchAll($sql) as $key => $value) {
			$list[] = $value['id'];
	  	}
		return $list;
	}

	public function getList($category_id = -1, $date = null)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name)
				  ->where('category_id = ?',$category_id)
				  ->order("sort asc");
		if($date != null){
			$sql->where('target_date=?', $date);
		}
	  	return $db->fetchAll($sql);
	}
	
	public function selectOptions($ctg_id = -1)
	{
		if (!$ctg_id) {
			$ctg_id = -1;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name)->where("category_id=?",$ctg_id);
	  	$result = $db->fetchAll($sql);
		
		$options = array();
		foreach ($result as $subcategory) {
			$options[$subcategory['id']] = $subcategory['title'];
		}
		
		return $options;
	}
	
	public function detail($id)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name)
				  ->where('id = ?',$id);
	  	return $db->fetchRow($sql);
	}
	
	public function tableData($category_id)
	{
		$headers = array("Title", "Created Time","Sort", "Control");
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name)
				  ->where('category_id = ?',$category_id)
				  ->order('sort asc');
				  // ->where('parent_id = ?',$parent_id);
	  	$result = $db->fetchAll($sql);
		
		$rows = array();
		foreach ($result as $key => $value) {
			$action = "<a class=\"nextStep\" href=\"/admin/manage/listcontent?subcategory_id=$value[id]\" class=\"\" >Contents</a>";
			$action.= " | <a href=\"/admin/manage/addsubcategory?id=$value[id]&category_id=$value[category_id]\" class=\"\" >Edit</a>";
			$action.= " | <a href=\"/admin/manage/deletesubcategory?id=$value[id]\" class=\"deleteRowBtn\" >Delete</a>";
			
			$row = array();
			$row[] = $value['title'];
			$row[] = $value['created_time'];
			$row[] = $value['sort'];
			$row[] = $action;
			
			$rows[] = $row;
		}
		return array('headers' => $headers, 'rows' => $rows);
	}
}