<?php
class Model_User extends Zend_Db_Table_Abstract{
	public $_name = 'user_admin';
	protected $_primary = "id";
	
	
	public function getByToken($token)
	{
		if (!$token) {
			return $this->fetchRow( $this->getDefaultAdapter()->quoteInto("token", $token) )->toArray();
		}
		return FALSE;
	}
	
	public function getByFbId($fbid)
	{
		if (!$token) {
			return $this->fetchRow( $this->getDefaultAdapter()->quoteInto("fbid", $fbid) )->toArray();
		}
		return FALSE;
	}
	
	public function getAllUserAdmin(){
		
	}
	
	public function getUserInfo($id){
		
	}
	
	/**
	 * Lấy thông tin user dựa vào username
	 * @param string $username : username của user
	 * @return Array $user_info : Thông tin của user nếu có
	 */
	public function getUserInfoByUsername($username){
		if (!$username){
			return false;
		}
		/**
		 * Adapter kết nối tới db
		 */
		$db = Zend_Db_Table::getDefaultAdapter();
		/**
		 * Câu select lấy thông tin user theo username
		 */
		$mySql = $db->select()
					->from(array("u"	=> $this->_name))
					->where("username = ?",$username);
		$user_info = $db->fetchRow($mySql);
		return $user_info;
	}
	function getAllUserList(){
		$db = Zend_Registry::get('connectDB');
		$mySql = $db->select()
					->from(array('u' => 'user_admin'),array('id','username','name'))
					->where("status = 1");
		$user_list = $db->fetchAll($mySql);
		return $user_list;
	}	
	function getPermissionManagerList(){
		$db = Zend_Registry::get('connectDB');
		$mySql = $db->select()
					->from(array('p' => 'permission_manager'),array())
					->join(array("u"	=> $this->_name),"u.id = p.user_id",array('id','username'))
					->where("u.status = 1");
		$user_list = $db->fetchAll($mySql);
		return $user_list;
	}
}