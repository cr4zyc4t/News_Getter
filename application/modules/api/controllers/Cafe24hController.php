<?php

class Api_Cafe24hController extends Zend_Controller_Action
{
	private $reply = array();
	private $test_mode = FALSE;
	public function init()
	{
		$this->_helper->viewRenderer->setNoRender();
		require_once "toanvq.php";
		
		$this->test_mode = isset($_GET['test']);
		$this->reply['success'] = FALSE;
	}
	
	public function postDispatch()
	{
		if ($this->test_mode) {
			arr_dump($this->_request->getParams());
			arr_dump($this->reply);
		}else{
			echo json_encode($this->reply);
		}
	}
	
	public function listcategoryAction()
	{
		$type = $this->_request->getParam('type');
		$sort = $this->_request->getParam('sort');
		
		$category_model = new Model_Category;
		$where = null;
		if ($type) {
			$where = $category_model->getAdapter()->quoteInto("type_id=?", $type);
			if ($sort) {
				$where = "type_id='$type' AND sort > '$sort'";
			}
		}
 		
		$this->reply['success'] = TRUE;
		$this->reply['list_category'] = $listcategory = $category_model->fetchAll($where)->toArray();
	}
	
	public function listsubcategoryAction()
	{
		$category_id = $this->_request->getParam('category_id');
		
		$subcategory_model = new Model_Subcategory;
		$where = null;
		if ($category_id) {
			$where = $subcategory_model->getAdapter()->quoteInto("category_id=?", $category_id);
		}
		$this->reply['success'] = TRUE;
		$this->reply['list_subcategory'] = $subcategory_model->fetchAll($where)->toArray();
	}
	
	public function listcontentAction()
	{
		Zend_Loader::loadClass('api_model_Contents');
		
		$subcategory_id = $this->_request->getParam('subcategory_id');
		
		$content_model = new Api_Model_Contents;
		$where = null;
		if ($subcategory_id) {
			$this->reply['success'] = TRUE;
			$this->reply['list_content'] = $content_model->getListContent($subcategory_id);
		}
	}
	
	public function contentdetailAction()
	{
		$content_id = $this->_request->getParam('content_id');
		
		$content_model = new Model_Contents;
		$where = null;
		if ($content_id) {
			$this->reply['success'] = TRUE;
			$this->reply['list_content'] = $content_model->getNewsDetail($content_id);
		}
	}
}