<?php
class Model_Log extends Zend_Db_Table_Abstract{
    public $_name = 'import_log';
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
}