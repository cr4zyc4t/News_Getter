<?php

class Api_TestController extends Vqt_Controller_Api //Thank god you are here!
{
	private $category_id = null;
	function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
	{
		$this->category_id = 133;
		parent::__construct($request, $response, $invokeArgs, $this->category_id);
	}
	
	public function testAction()
	{
		$this->reply['fafawf'] = "afewaw";
		echo $this->category_id;
	}
}
