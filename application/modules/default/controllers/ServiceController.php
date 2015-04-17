<?php

class ServiceController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function getcategoriesAction()
	{
		$subcategory = new Model_Subcategory;
		$module_id = $this->_request->getParam('module_id');
		$target_date = $this->_request->getParam('date');

		if ($module_id) {
			if($target_date)
			{
				echo json_encode($subcategory->getList($module_id) );
			}else{
				echo json_encode( $subcategory->getList($module_id, $target_date) );
			}
		}else{
			echo json_encode( array() );
		}
		
	}
	
	public function getnewslistAction()
	{
		$news = new Model_News;
		
		$subcategory_id = $this->_request->getParam('category_id');
		if ($subcategory_id) {
			echo json_encode($news->getNewsList($subcategory_id) );
		}else{
			echo json_encode(array());
		}
	}
	
	public function getnewsdetailAction()
	{
		$news = new Model_News;
		
		$news_id = $this->_request->getParam('news_id');
		if ($news_id) {
			$news_detail = $news->getNewsDetail($news_id);
			echo json_encode($news_detail);
		}else{
			echo json_encode(array());
		}
	}
	
	public function autogetLogAction()
	{
		$model = new Model_AutoGetLog;
		
		$last_exception = $this->_request->getParam('last_exception');
		$info = $this->_request->getParam('run_log');
		if ($last_exception) {
			if ($info) {
				$model->insert(array("last_exception" => $last_exception, "info" => $info));
			}else{
				$model->insert(array("last_exception" => $last_exception));
			}
			
		}
	}
}