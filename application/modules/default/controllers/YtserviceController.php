<?php

class YtserviceController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->viewRenderer->setNoRender();
		include_once 'toanvq.php';
	}
	
	public function playAction()
	{
		$success = FALSE;
		$info = "";
		$reply = array();
		
		$content_id = $this->_request->getParam('content_id');
		if (is_numeric($content_id)) {
			$content_model = new Model_Contents;
			$content_model->playCount($content_id);
			
			$success = TRUE;
		}
		
		$reply['success'] = $success;
		$reply['info'] = $info;
		echo json_encode($reply);
	}
	
	public function reportAction()
	{
		$success = FALSE;
		$info = "";
		$reply = array();
		
		$content_id = $this->_request->getParam('content_id');
		$code = $this->_request->getParam('code');
		$duration = $this->_request->getParam('duration');
		
		if (is_numeric($content_id)) {
			switch ($code) {
				case 1:
					
					break;
				default:
					$content_model = new Model_Contents;
					$content_model->setStatus($content_id, 0);
					
					$content = $content_model->detail($content_id);
					
					$error_model = new Model_NewsError;
					$error_model->add($content['url']);
					break;
			}
			
			
			$success = TRUE;
		}
		
		$reply['success'] = $success;
		$reply['info'] = $info;
		echo json_encode($reply);
	}
	
	public function getsubcategoriesAction()
	{
		$success = FALSE;
		$info = "";
		$reply = array();
		
		$category_id = $this->_request->getParam('category_id');
		if (is_numeric($category_id)) {
			$subcategory_model = new Model_Subcategory;
			$list = $subcategory_model->getList($category_id);
			
			$success = TRUE;
			$reply['category_list'] = $list;
		}
		
		$reply['success'] = $success;
		$reply['info'] = $info;
		echo json_encode($reply);
	}
	
	public function getvideosAction()
	{
		$success = FALSE;
		$info = "";
		$reply = array();
		
		$subcategory_id = $this->_request->getParam('subcategory_id');
		if (is_numeric($subcategory_id)) {
			$content_model = new Model_Contents;
			$list = $content_model->getVideoList($subcategory_id);
			
			$success = TRUE;
			$reply['video_list'] = $list;
		}
		
		$reply['success'] = $success;
		$reply['info'] = $info;
		echo json_encode($reply);
	}
	
	
	public function searchAction()
	{
		$success = FALSE;
		$info = "";
		$reply = array();
		
		$subcategory_id = $this->_request->getParam('subcategory_id');
		$keyword = $this->_request->getParam('keyword');
		
		if (!$subcategory_id) {
			$subcategory_id = -1;
		}
		if (is_numeric($subcategory_id) && $keyword) {
			$content_model = new Model_Contents;
			$list = $content_model->seachContent($keyword, $subcategory_id);
			
			$success = TRUE;
			$reply['video_list'] = $list;
		}
		
		$reply['success'] = $success;
		$reply['info'] = $info;
		echo json_encode($reply);
	}
	
	
}