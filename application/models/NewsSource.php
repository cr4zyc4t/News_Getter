<?php
require_once 'Zend/Db/Table/Abstract.php';
class Model_NewsSource extends Zend_Db_Table_Abstract
{
	public $_name = 'source';
	protected $_primary = 'id';

	public function getByTitle($title){
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
			->from($this->_name)
			->where('title = ?',$title);
		return $db->fetchRow($sql);
	}

	public function detail($id = -1)
	{
		if (!$id) {
			$id = -1;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql =$db->select()->from( $this->_name )->where("id=?", $id);
	  	return $db->fetchRow($sql);
	}
	
	public function getSourceList(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("s"	=> $this->_name),array("id","name","circle_icon",'square_icon'));
		$result = $db->fetchAll($mySql);
		return $result;
	} 
	public function getSourceListByCategory($arrParam){
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array('l'	=> "link_get_content"),array())
					->join(array('sc'	=> "sub_category"), "l.sub_category_id = sc.id",array())
					->join(array("s"	=> $this->_name),"l.source_id = s.id",array("id","name","circle_icon",'square_icon'))
					->group("s.id")
					;
		if (isset($arrParam['category_id'])){
			$mySql->where("sc.category_id = ?",$arrParam['category_id']);
		}
		$result = $db->fetchAll($mySql);
		return $result;
	}
	
	public function selectOptions($include_none = FALSE)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from($this->_name);
	  	$result = $db->fetchAll($sql);
		
		$options = array();
		foreach ($result as $subcategory) {
			$options[$subcategory['id']] = $subcategory['title'];
		}
		
		return $options;
	}
	
	public function tableData()
	{
		$headers = array("Title", "Homepage","Module Name","Created Time","Control");
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name);
	  	$result = $db->fetchAll($sql);
		
		$rows = array();
		foreach ($result as $key => $value) {
			$action = "<a href=\"/admin/resource/addpage?id=$value[id]\" class=\"\" >Edit</a>";
			$action.= " | <a href=\"/admin/resource/deletepage?id=$value[id]\" class=\"deleteRowBtn\" >Delete</a>";
			
			$row = array();
			$row[] = "<img src=\"$value[icon]\" width=\"40\" alt=\"logo\">".$value['title'];
			$row[] = $value['homepage'];
			$row[] = $value['module_name'];
			$row[] = $value['create_time'];
			$row[] = $action;
			
			$rows[] = $row;
		}
		return array('headers' => $headers, 'rows' => $rows);
	}
}