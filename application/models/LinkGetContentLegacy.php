<?php
class Model_LinkGetContentLegacy extends Zend_Db_Table_Abstract{
	public $_name = 'link_get_content_legacy';
	protected $_primary = "id";
	
	public function detail($id = -1)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql =$db->select()
				  ->from( array("url" => $this->_name) )
				  ->joinLeft( array("sc"	=> "sub_category"), "sc.id = url.sub_category_id",array("category_id"))
				  ->where("url.id = ?",$id);
	  	return $db->fetchRow($sql);
	}
	
	public function markAsFinish($id)
	{
		$this->update(array("processed"	=> 1), "id=$id");
	}
	
	public function markAsReady($id)
	{
		$this->update(array("processed"	=> 0), "id=$id");
	}
	
	public function markAsError($id)
	{
		$this->update(array("processed"	=> -1), "id=$id");
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
		$headers = array("&nbsp;","Title","Source","Category","Sub Catgegory","URL","Processed","Control");
		
		$db = Zend_Db_Table::getDefaultAdapter();
		try{
			$sql = $db->select()
				  ->from( array("url" => $this->_name) )
				  ->joinLeft( array("s"	=> "source"), "s.id = url.source_id",array("source" => "s.title", "icon"))
				  ->joinLeft( array("sc"=> "sub_category"), "sc.id = url.sub_category_id",array("subcategory" => "sc.title"))
				  ->joinLeft( array("c"=> "category"), "c.id = sc.category_id",array("category" => "c.title"))
				  // ->where('url.processed = ?',-1)
				  ->order('url.create_time desc');
	  		$result = $db->fetchAll($sql);
		}catch(exception $e){
			echo $e;
		}
		
		
		$rows = array();
		foreach ($result as $key => $value) {
			$action = "<a href=\"/qplayvn/index/addlink?id=$value[id]\" class=\"nextStep \" >Edit</a>";
			// $action.= " | <a href=\"/admin/resource/deletelink?id=$value[id]\" class=\"deleteRowBtn\" >Delete</a>";
			// $action.= " | <a href=\"/$value[module_name]/import/getcontent?id=$value[id]\" class=\"getContentBtn\" >GetNow</a>";
			
			$row = array();
			$row['noClick col-selector'] = "<input type=\"checkbox\" class=\"simple hidden inline-checkbox\" name=\"check[]\" value=\"$value[id]\">";
			$row[] = $value['name'];
			$row[] = $value['source'];
			$row[] = $value['category'];
			$row[] = $value['subcategory'];
			$row[] = $value['url'];
			$row[] = $value['processed'];
			$row[] = $action;
			
			$rows[] = $row;
		}
		return array('headers' => $headers, 'rows' => $rows);
	}
}