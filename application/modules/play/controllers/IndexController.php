<?php

class Play_IndexController extends Zend_Controller_Action
{
	public function init()
	{
		$option=array(
	        "layout" => "play",
	        "layoutPath" => APPLICATION_PATH."/layouts/scripts/"
      	);
      	Zend_Layout::startMvc($option);
        $this->view->headTitle("QHOnline - Zend Layout");

		include_once 'demo.php';
	}
	
	public function indexAction()
	{
		$this->view->navibar = navibar(0);
//		$this->view->pageSubtitle = "List category";
		$this->view->pageHeader = "Popular Video";


		$video_model = new Model_Contents;

		$this->view->videos = $video_model->allVideos();
	}

	public function categoryAction()
	{
		$id = $this->_request->getParam("id");
		if($id){
			$category_model = new Model_Category;
			$subcategory_model = new Model_Subcategory;
			$category = $category_model->detail($id);

			$this->view->navibar = navibar($id);

			$this->view->pageHeader = $category['title'];

			$this->view->subcategories = $subcategory_model->getList($id);
		}

	}

	public function subcategoryAction()
	{
		$id = $this->_request->getParam("id");
		if($id){
			$category_model = new Model_Category;
			$subcategory_model = new Model_Subcategory;
			$video_model = new Model_Contents;

			$subcategory = $subcategory_model->detail($id);
			$category = $category_model->detail($subcategory['category_id']);

			$this->view->navibar = navibar($subcategory['category_id']);
			$this->view->pageSubtitle = $subcategory['title'];
			$this->view->pageHeader = $category['title'];

			$this->view->videos = $video_model->getVideoList($subcategory['id']);

		}

	}

	public function videoAction(){

		$id = $this->_request->getParam("id");
		if($id){
			$content_model = new Model_Contents;
			$subcategory_model = new Model_Subcategory;

			$video = $content_model->detail($id);
			$subcategory = $subcategory_model->detail($video['subcategory_id']);

			$this->view->navibar = navibar($subcategory['category_id']);
			$this->view->pageSubtitle = $video['title'];
			$this->view->pageHeader = $subcategory['title'];

			$this->view->video = $video;
			$this->view->subcategory = $subcategory;
		}

	}
}