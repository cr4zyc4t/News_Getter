<?php

class SKBB_ServiceController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function getcategoriesAction()
	{
		$category = new Model_Category;
		
		echo json_encode($category->getByParentId(1));
	}
	
	public function getnewslistAction()
	{
		$news = new Model_News;
		
		$category_id = $this->_request->getParam('category_id');
		if ($category_id) {
			echo json_encode($news->getNewsList($category_id) );
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
}