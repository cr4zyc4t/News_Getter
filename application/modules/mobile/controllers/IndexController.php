<?php

class Mobile_IndexController extends Zend_Controller_Action
{
	public function init()
	{
		$option=array(
	        "layout" => "mobile",
	        "layoutPath" => APPLICATION_PATH."/layouts/scripts/"
      	);
      	Zend_Layout::startMvc($option);
        // $this->view->pageTitle = "Amobi - toanvq";
        // $this->view->pageHeader = "Import";
        include 'toanvq.php';
	}
	
	public function indexAction()
	{
		$this->view->navibar = navibar(2,1);
		
		$this->view->pageHeader = "Import";
		$this->view->pageSubtitle = "Video";
	}
}