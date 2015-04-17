<?php
class Model_AccessLog extends Zend_Db_Table_Abstract{
    public $_name = 'access_count';
    protected $_primary = "id";

    public function detail($id = -1)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $db->select()
            ->from($this->_name);
        if($id != -1){
            $sql->where('id = ?',$id);
        }

        return $db->fetchRow($sql);
    }
	
	public function lastDateReport()
	{
		$db = Zend_Db_Table::getDefaultAdapter();

        return $db->fetchRow("SELECT `date` FROM $this->_name ORDER BY `date` DESC LIMIT 1");
	}
	
    public function getByDate($date)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $db->select()->from($this->_name)->where('date = ?',$date);

        return $db->fetchRow($sql);
    }

    public function chartData($limit = 7)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        return $db->fetchAll("SELECT * FROM $this->_name ORDER BY date DESC LIMIT $limit");
    }

    public function getAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $sql = $db->select()
            ->from($this->_name);
        return $db->fetchAll($sql);
    }
}