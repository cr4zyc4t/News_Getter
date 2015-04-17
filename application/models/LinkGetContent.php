<?php
class Model_LinkGetContent extends Zend_Db_Table_Abstract{
	public $_name = 'link_get_content';
	protected $_primary = "id";
	
	public function detail($id = -1)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql =$db->select()
				  ->from( array("url" => $this->_name) )
				  ->joinLeft( array("s"	=> "source"), "s.id = url.source_id",array("source" => "s.title","home_page" => "homepage"))
				  ->joinLeft( array("sc"	=> "sub_category"), "sc.id = url.subcategory_id",array("category_id"))
				  ->where("url.id = ?",$id);
	  	return $db->fetchRow($sql);
	}
	
	public function getAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		
		$sql = $db->select()
				  ->from($this->_name)
				  ->where('processed = ?', 0);
		return $db->fetchAll($sql);
	}
	
	public function getLink($source_id)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		
		$sql = $db->select()
				  ->from(array('l'=> $this->_name))
				  ->joinLeft(array('s'	=> "source"), "l.source_id = s.id",array("home_page" => "homepage"))
				  ->where('source_id = ?', $source_id);
		return $db->fetchAll($sql);
	}
	
	public function tableData()
	{
		$headers = array("Title","Source","Category","Sub Catgegory","Type","URL","Last Time Get"," ","Control");
		
		$db = Zend_Db_Table::getDefaultAdapter();
		try{
			$sql = $db->select()
				  ->from( array("url" => $this->_name) )
				  ->joinLeft( array("s"	=> "source"), "s.id = url.source_id",array("source" => "s.title", "module_name"))
				  ->joinLeft( array("t"	=> "type"), "t.id = url.type_id",array("type" => "t.title"))
				  ->joinLeft( array("sc"=> "sub_category"), "sc.id = url.subcategory_id",array("subcategory" => "sc.title"))
				  ->joinLeft( array("c"=> "category"), "c.id = sc.category_id",array("category" => "c.title"))
				  ->order('url.create_time desc');
				  // ->where('parent_id = ?',$parent_id);
	  		$result = $db->fetchAll($sql);
		}catch(exception $e){
			echo $e;
		}
		
		
		$rows = array();
		foreach ($result as $key => $value) {
			$action = "<a href=\"/admin/resource/addlink?id=$value[id]\" class=\"nextStep \" >Edit</a>";
			$action.= " | <a href=\"/admin/resource/deletelink?id=$value[id]\" class=\"deleteRowBtn\" >Delete</a>";
			$action.= " | <a href=\"/$value[module_name]/import/getcontent?id=$value[id]\" class=\"getContentBtn\" >GetNow</a>";
			
			$row = array();
			$row[] = $value['title'];
			$row[] = $value['source'];
			$row[] = $value['category'];
			$row[] = $value['subcategory'];
			$row[] = $value['type'];
			$row[] = $value['url'];
			$row[] = $value['last_run'];
			$row["noClick"] = "<input type=\"checkbox\" class=\"simple importcheck inline-checkbox\" name=\"import$value[id]\" value=\"$value[id]\">";
			$row[] = $action;
			
			$rows[] = $row;
		}
		return array('headers' => $headers, 'rows' => $rows);
	}
}