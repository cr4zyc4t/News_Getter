<?php
class Model_PartnerCategory extends Zend_Db_Table_Abstract
{
	public $_name = 'partner_category';
	protected $_primary = 'id';

	public function getCategoryList($arrParam = null){
		if (!isset($arrParam['partner_id'])){
			return null;
		}
		$db = Zend_Db_Table::getDefaultAdapter();
		$mySql = $db->select()
					->from(array("c"	=> $this->_name),array("id","name"))
					->join(array("p"	=> "partner"), "p.id = c.partner_id",array())
					->where("p.partner_id = ?", $arrParam['partner_id']);
//					->where("status = 1");
//		if (isset($arrParam['order']) && isset($arrParam['order_column']) && in_array($arrParam['order_column'], array('id','sort','name'))){
//			$mySql->order("c." . $arrParam['order_column'] . " " . $arrParam['order']);
//		}
		$result = $db->fetchAll($mySql);
		return $result;
	} 
	function checkcate($friendly_link){
		$db = Zend_Registry::get('connectDB');
		$mysql = $db->select()
					->from(array("c"	=> $this->_name))
					->where("friendly_link =?",$friendly_link);
		$list = $db->fetchRow($mysql);
		return $list;
	}
}