<?php
class Model_Comment extends Zend_Db_Table_Abstract
{
	public $_name = 'news';
	protected $_primary = 'id';
	
	public function getInfo($ids)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		if (is_array($ids)) {
			$sql =$db->select()->from( $this->_name )->where("id IN(?)", $ids);
		  	return $db->fetchAll($sql);
		}
		if (is_numeric($ids)) {
			$sql =$db->select()->from( $this->_name )->where("id=?", $ids);
		  	return $db->fetchAll($sql);
		}
		return null;
	}
	
	public function detail($id)
	{
		if (!isset($id)) {
			$id = -1;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		
		$sql =$db->select()->from( $this->_name )->where("id=?", $id);
	  	return $db->fetchRow($sql);
	}
	
	public function getHighLight($limit = 9, $offset = 0)
	{
		$model_category = new Model_Category;
		$model_subcategory = new Model_Subcategory;
		$model_source = new Model_NewsSource;
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from( array("c" => $this->_name) )
				  ->joinLeft( array("sc"	=> $model_subcategory->_name), "sc.id = c.subcategory_id",array("sub_category_name" => "sc.title"))
				  ->joinLeft( array("ctg"	=> $model_category->_name), "ctg.id = sc.category_id",array("category" => "ctg.title"))
				  ->joinLeft( array("s"	=> $model_source->_name), "s.id = c.source_id",array("source" => "s.title"))
				  ->where("ctg.sort >= ?", 1000)
				  ->where("sc.type_id=?", 1)
				  ->where("c.time >= ?", date("Y-m-d 00:00:00", time()-86400*30))
				  ->order('c.view desc')
				  ->limit($limit, $offset);
	  	return $result = $db->fetchAll($sql);
	}
	
	public function getHighLightByCategory($category_id,$limit = 9, $offset = 0)
	{
		$model_category = new Model_Category;
		$model_subcategory = new Model_Subcategory;
		$model_source = new Model_NewsSource;
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from( array("c" => $this->_name) )
				  ->joinLeft( array("sc"	=> $model_subcategory->_name), "sc.id = c.subcategory_id",array("sub_category_name" => "sc.title"))
				  ->joinLeft( array("ctg"	=> $model_category->_name), "ctg.id = sc.category_id",array("category" => "ctg.title"))
				  ->joinLeft( array("s"	=> $model_source->_name), "s.id = c.source_id",array("source" => "s.title"))
				  ->where("ctg.id = ?", $category_id)
				  ->where("ctg.type_id=?", 2)
				  ->where("c.time >= ?", date("Y-m-d 00:00:00", time()-86400*30))
				  ->order('c.view desc')
				  ->limit($limit, $offset);
	  	return $result = $db->fetchAll($sql);
	}
	
	public function getNewest($limit = 9,$offset = 0)
	{
		$model_category = new Model_Category;
		$model_subcategory = new Model_Subcategory;
		$model_source = new Model_NewsSource;
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from( array("c" => $this->_name) )
				  ->joinLeft( array("sc"	=> $model_subcategory->_name), "sc.id = c.subcategory_id",array("sub_category_name" => "sc.title"))
				  ->joinLeft( array("ctg"	=> $model_category->_name), "ctg.id = sc.category_id",array("category" => "ctg.title"))
				  ->joinLeft( array("s"	=> $model_source->_name), "s.id = c.source_id",array("source" => "s.title"))
				  ->where("ctg.sort >= ?", 1000)
				  ->where("sc.type_id=?", 1)
				  ->order('c.time desc')
				  ->limit($limit, $offset);
	  	return $result = $db->fetchAll($sql);
	}
	
	public function getByTag($tag_name, $limitcount = 9, $limitoffset = 0)
	{
		$model_category = new Model_Category;
		$model_subcategory = new Model_Subcategory;
		$model_source = new Model_NewsSource;
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from( array("c" => $this->_name) )
				  ->joinLeft( array("sc"	=> $model_subcategory->_name), "sc.id = c.subcategory_id",array("sub_category_name" => "sc.title"))
				  ->joinLeft( array("ctg"	=> $model_category->_name), "ctg.id = sc.category_id",array("category" => "ctg.title"))
				  ->joinLeft( array("s"	=> $model_source->_name), "s.id = c.source_id",array("source" => "s.title"))
				  ->where("c.sys_tag LIKE ?", "%$tag_name%")
				  ->where("c.time >= ?", date("Y-m-d 00:00:00", time()-86400*30))
				  ->order('c.created_time desc')
				  ->limit($limitcount,$limitoffset);
	  	return $result = $db->fetchAll($sql);
	}
	
	public function getByCategory($category_id = -1, $limitcount = 9, $limitoffset = 0)
	{
		$model_category = new Model_Category;
		$model_subcategory = new Model_Subcategory;
		$model_source = new Model_NewsSource;
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from( array("c" => $this->_name) )
				  ->joinLeft( array("sc"	=> $model_subcategory->_name), "sc.id = c.subcategory_id",array("sub_category_name" => "sc.title"))
				  ->joinLeft( array("ctg"	=> $model_category->_name), "ctg.id = sc.category_id",array("category" => "ctg.title"))
				  ->joinLeft( array("s"	=> $model_source->_name), "s.id = c.source_id",array("source" => "s.title"))
				  ->where("sc.category_id=?", $category_id)
				  ->order('c.created_time desc')
				  ->limit($limitcount,$limitoffset);
	  	return $result = $db->fetchAll($sql);
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
	
	public function getNewsList($subcategory_id = -1)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name, array("id", "created_time","title", "description", "icon","time"))->where('subcategory_id=?',$subcategory_id);
		
		return $db->fetchAll($sql);
	}
	
	public function getVideoList($subcategory_id)
	{
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = $db->select()->from($this->_name)->where('subcategory_id=?',$subcategory_id)->order('sort desc');
		
		$list = $db->fetchAll($sql);
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['content'] = str_replace("\r\n", '',strip_tags($list[$i]['content']));
			$list[$i]['url'] = str_replace("\r\n", '',strip_tags($list[$i]['url']));
		}
		
		return $list;
	}
	
	public function seachContent($keyword, $subcategory_id = -1, $limitcount = 9, $limitoffset = 0)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT * FROM $this->_name WHERE `title` LIKE '%$keyword%' ";
		if (is_array($subcategory_id)) {
			$sql.= " AND `subcategory_id` IN (". implode(",", $subcategory_id) .")";
		}elseif (is_numeric($subcategory_id)) {
			if ($subcategory == -1) {
				$sql.= " AND `subcategory_id` IN (32,33)";
			}else{
				$sql.= " AND `subcategory_id` = $subcategory_id";
			}
		}
		
		$sql.= "ORDER BY view DESC LIMIT $limitoffset, $limitcount";
		
		return $db->fetchAll($sql);
	}
	
	public function getNewsDetail($id = -1, $isRead = TRUE){
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name))
					->joinLeft(array('s'	=> "source"), "n.source_id = s.id",array("source_icon"	=> "icon",'source_name'	=> 'title'))
					->joinLeft(array('subctg'	=> "sub_category"), "subctg.id = n.subcategory_id",array("category_id" => "subctg.category_id"))
					->where("n.id = ?", $id);
		$result = $db->fetchRow($mySql);
		
		if ($isRead) {
			$sql = "UPDATE `$this->_name` SET `view`=`view`+1 WHERE `id`=$id";
			$db->query($sql);
		}
		
		// $result['tags'] = explode(",", $result['tag']);
		// unset($result['tag']);
		
		return $result;
	} 

	public function tableData($subcategory_id)
	{
		$headers = array("&nbsp;","Title","Source","Description","Updated","Order","Control");

		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
				  ->from( array("sc" => $this->_name) )
				  ->where('subcategory_id = ?',$subcategory_id)
				  ->joinLeft( array("s"	=> "source"), "s.id = sc.source_id",array("source" => "s.title"))
				  ->order('sort desc')->order("time desc");
				  // ->where('parent_id = ?',$parent_id);
	  	$result = $db->fetchAll($sql);
		
		$rows = array();
		foreach ($result as $key => $value) {
			$action = "<a class=\"nextStep\" href=\"/admin/manage/addcontent?subcategory_id=$value[subcategory_id]&id=$value[id]\" class=\"\" >Edit</a>";
			$action.= " | <a href=\"/admin/manage/deletecontent?id=$value[id]\" class=\"deleteRowBtn\" >Delete</a>";
			
			$row = array();
			$row['noClick col-selector'] = "<input type=\"checkbox\" class=\"simple hidden inline-checkbox\" name=\"check[]\" value=\"$value[id]\">";
			$row['title'] = $value['title'];
			$row['source'] = $value['source'];
			$row['desc'] = substr( $value['description'], 0, 70)."...";
			$row['time'] = $value['time'];
			$row['noClick col-sort'] = "<input type=\"text\" rel=\"$value[id]\" class=\"integer-input input-sm intable-input\" value=\"$value[sort]\">" ;
			$row['action'] = $action;
			
			$rows[] = $row;
		}
		return array('headers' => $headers, 'rows' => $rows);
	}
	
	///OLD FUNCTION
	public function getTopNewsList($category = 0,$number = 10,$source = null,$page = 1,$sub_category = 0,$tag=null){
		if (!$number) {
			$number = 10;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name))
					->join(array("sc"	=> "sub_category"), "sc.id = n.sub_category_id",array("sub_category_name"	=> "name",'category_id'	=> "category_id"))
					->joinLeft(array('s'	=> "source"), "n.source_id = s.id",array("source_circle_icon"	=> "circle_icon","source_square_icon"	=> "square_icon",'source_name'	=> 'name'))
					->order("n.time DESC")
					->where("processed = ?",1)
					->limitPage($page, $number);
        // Chi lay nhung bai viet trong mot thang gan nhat
        $mySql->where("n.time >= ?", date("Y-m-d 00:00:00", time()-86400*30));
		if ($category){
			$mySql->where("sc.category_id = ?", $category);
		}
		if ($sub_category){
			$mySql->where("sc.id = ?", $sub_category);
		}
		if ($source){
			$mySql->where("source_id in (?)", explode(",", $source));
		}
		if ($tag){
			$mySql->where("tag like ?", "%" . $tag . "%");
		}
		$result = $db->fetchAll($mySql);
		return $result;
	} 
	// public function getNewsList($arrParam){
		// $db = Zend_Db_Table::getDefaultAdapter();
		// $mySql = $db->select()
					// ->from(array("n"	=> $this->_name))
					// ->join(array("sc"	=> "sub_category"), "sc.id = n.sub_category_id",array("sub_category_name"	=> "name",'category_id'	=> "category_id"))
					// ->joinLeft(array('s'	=> "source"), "n.source_id = s.id",array("source_circle_icon"	=> "circle_icon","source_square_icon"	=> "square_icon",'source_name'	=> 'name'))
					// ->order("n.time DESC")
					// ->where("processed = ?",1);
        // // Chi lay nhung bai viet trong mot thang gan nhat
        // $mySql->where("n.time >= ?", date("Y-m-d 00:00:00", time()-86400*30));
		// if (isset($arrParam['page']) && isset($arrParam['number']) && $arrParam['page'] && $arrParam['number']){
			// $mySql->limitPage($arrParam['page'], $arrParam['number']);
		// }else{
			// $mySql->limit(10);
		// }
		// $result = $db->fetchAll($mySql);
		// return $result;
	// }
	
	public function getHighLightNewsList($arrParam){
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name),array("*","view"	=> new Zend_Db_Expr("(case when (DATE_ADD(time,INTERVAL 2 HOUR) > now()) then view else 0 end)")))
					->join(array("sc"	=> "sub_category"), "sc.id = n.sub_category_id",array("sub_category_name"	=> "name",'category_id'	=> "category_id"))
					->joinLeft(array('s'	=> "source"), "n.source_id = s.id",array("source_circle_icon"	=> "circle_icon","source_square_icon"	=> "square_icon",'source_name'	=> 'name'))
					->order("view DESC")
					->order("n.time DESC")
					->where("n.high_light = ?",1)
					->where("processed = ?",1);
        // Chi lay nhung bai viet trong mot thang gan nhat
        $mySql->where("n.time >= ?", date("Y-m-d 00:00:00", time()-86400*30));
		if (isset($arrParam['page']) && isset($arrParam['number']) && $arrParam['page'] && $arrParam['number']){
			$mySql->limitPage($arrParam['page'], $arrParam['number']);
		}else{
			$mySql->limit(10);
		}
		$result = $db->fetchAll($mySql);
		return $result;
	} 
	// public function getNewsDetail($id){
		// if (!$id) {
			// return FALSE;
		// }
		// $db = Zend_Db_Table::getDefaultAdapter();
		// $mySql = $db->select()
					// ->from(array("n"	=> $this->_name))
					// ->join(array("sc"	=> "sub_category"), "sc.id = n.sub_category_id",array("sub_category_name"	=> "name",'category_id'	=> "category_id"))
					// ->joinLeft(array('s'	=> "source"), "n.source_id = s.id",array("source_circle_icon"	=> "circle_icon","source_square_icon"	=> "square_icon",'source_name'	=> 'name'))
					// ->where("n.processed = ?",1)
					// ->where("n.id = ?", $id);
		// $result = $db->fetchRow($mySql);
		// return $result;
	// } 
	public function getPartnerNewsList($category = 0,$number = 10,$page = 1,$tag=null){
		if (!$number) {
			$number = 10;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name))
					->join(array("pc"	=> "partner_category"), "pc.id = n.partner_category_id",array("partner_category_name"	=> "name"))
					->order("n.time DESC")
					->where("processed = ?",1)
					->limitPage($page, $number);
        // Chi lay nhung bai viet trong mot thang gan nhat
        $mySql->where("n.time >= ?", date("Y-m-d 00:00:00", time()-86400*30));
		if ($category){
			$mySql->where("n.partner_category_id = ?", $category);
		}
		if ($tag){
			$mySql->where("tag like ?", "%" . $tag . "%");
		}
		$result = $db->fetchAll($mySql);
		return $result;
	} 
	public function getTopPartnerNewsList($arrParam){
		if (!isset($arrParam['partner_id'])){
			return NULL;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name))
					->join(array("pc"	=> "partner_category"), "pc.id = n.partner_category_id",array("partner_category_name"	=> "name"))
					->join(array("p"	=> "partner"), "p.id = pc.partner_id",array())
					->order("n.time DESC")
					->where("processed = ?",1)
					->where("p.partner_id = ?",$arrParam['partner_id']);
        // Chi lay nhung bai viet trong mot thang gan nhat
        $mySql->where("n.time >= ?", date("Y-m-d 00:00:00", time()-86400*30));
		if (isset($arrParam['page']) && isset($arrParam['number']) && $arrParam['page'] && $arrParam['number']){
			$mySql->limitPage($arrParam['page'], $arrParam['number']);
		}else{
			$mySql->limit(10);
		}
		$result = $db->fetchAll($mySql);
		return $result;
	}
	public function getPartnerHighLightNewsList($arrParam){
		if (!isset($arrParam['partner_id'])){
			return NULL;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("n"	=> $this->_name),array("*","view"	=> new Zend_Db_Expr("(case when (DATE_ADD(time,INTERVAL 2 HOUR) > now()) then view else 0 end)")))
					->join(array("pc"	=> "partner_category"), "pc.id = n.partner_category_id",array("partner_category_name"	=> "name"))
					->join(array("p"	=> "partner"), "p.id = pc.partner_id",array())
					->order("view DESC")
					->order("n.time DESC")
					->where("n.high_light = ?",1)
					->where("processed = ?",1)
					->where("p.partner_id = ?",$arrParam['partner_id']);
        // Chi lay nhung bai viet trong mot thang gan nhat
        $mySql->where("n.time >= ?", date("Y-m-d 00:00:00", time()-86400*30));
        
		if (isset($arrParam['page']) && isset($arrParam['number']) && $arrParam['page'] && $arrParam['number']){
			$mySql->limitPage($arrParam['page'], $arrParam['number']);
		}else{
			$mySql->limit(10);
		}
		$result = $db->fetchAll($mySql);
		return $result;
	}


//	demo function
	public function allVideos()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()->from($this->_name)->order('sort desc');

		return $db->fetchAll($sql);
	}
}