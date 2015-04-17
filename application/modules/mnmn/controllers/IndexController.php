<?php

class MNMN_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$news = new Model_News;
		
		$id = $this->_request->getParam('id');
		if (!$id) {
			$id = 1;
		}
		$source = $news->getPageSource($id);
		
		echo $source[0]['content'];
	}
}