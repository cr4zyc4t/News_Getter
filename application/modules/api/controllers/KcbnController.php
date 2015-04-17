<?php

class Api_KcbnController extends Zend_Controller_Action //Ke chuyen be nghe
{
	private $category_id = 133;
	
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
	
	public function loginByFacebookAction()
	{
		$fbid = $this->_request->getParam('fbid');
		$token = $this->_request->getParam('token');
		
		$model_user = new Model_User;
		
		if ( $fbid && $token ) {
			if ($user = $model_user->getByFbId($fbid) ) {
				
			}
		}
	}
	
	public function videoInfoAction()
	{
		$ids = $this->_request->getParam('ids');
		if (is_array($ids) || is_numeric($ids)) {
			$content_model = new Model_Contents;
			$info = $content_model->getInfo($ids);
			$this->reply['success'] = TRUE;
			$this->reply['video_list'] = $info;
		}
	}
	
	public function playAction()
	{
		$content_id = $this->_request->getParam('content_id');
		if (is_numeric($content_id)) {
			$content_model = new Model_Contents;
			$info = $content_model->detail($content_id);
			$content_model->playCount($content_id);
			$this->reply['success'] = TRUE;
			$this->reply['info'] = $info;
		}
	}
	
	public function reportAction()
	{
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
			
			$this->reply['success'] = TRUE;
			$this->reply['info'] = $info;
		}
	}
	
	public function getsubcategoriesAction()
	{
		if (is_numeric($this->category_id)) {
			$subcategory_model = new Model_Subcategory;
			$list = $subcategory_model->getList($this->category_id);
			
			$this->reply['success'] = TRUE;
			$this->reply['category_list'] = $list;
		}
	}
	
	public function getvideosAction()
	{
		$subcategory_id = $this->_request->getParam('subcategory_id');
		if (is_numeric($subcategory_id)) {
			$content_model = new Model_Contents;
			$list = $content_model->getVideoList($subcategory_id);
			
			$this->reply['success'] = TRUE;
			$this->reply['video_list'] = $list;
		}
	}
	
	
	public function searchAction()
	{
		$keyword = $this->_request->getParam('keyword');
		
		$page = $this->_request->getParam('page');
		$count = $this->_request->getParam('count');
		if (!$count) {
			$count = 9;
		}
		if (!$page) {
			$page = 1;
		}
		
		if ($keyword) {
			$keyword = @mb_convert_encoding($keyword, 'utf-8', mb_detect_encoding($keyword));
			$content_model = new Model_Contents;
			$model_subcategory = new Model_Subcategory;
			$list = $content_model->seachContent($keyword, $model_subcategory->getListSubCtg($this->category_id),$count, $count*( $page-1 ));
			
			$this->reply['success'] = TRUE;
			$this->reply['video_list'] = $list;
		}
	}
	
	public function getHighlightAction()
	{
		$page = $this->_request->getParam('page');
		if (!$page) {
			$page = 1;
		}
		
		$model_content = new Model_Contents;
		
		$this->reply['success'] = TRUE;
		$this->reply['video_list'] = $model_content->getHighLightByCategory($this->category_id, 9, 9*( $page-1 ));
	}
	
	public function getCommentsAction()
	{
		$content_id = $this->_request->getParam('content_id');
		$model_comment = new Model_Comment;
		$model_content = new Model_Contents;
		
		$validator = new Zend_Validate_Db_RecordExists(
							array(
								"table"	=> $model_content->_name,
								'field' => 'id'
							)
						);
		if ($validator->isValid($content_id)) {
			$this->reply['success'] = TRUE;
			$this->reply['comments'] = $model_comment->getByContentId($content_id);
		}else{
			$this->reply['info'] = "Content not found";
		}
	}
	
	public function addCommentAction()
	{
		$token = $this->_request->getParam('token');
		$content_id = $this->_request->getParam('content_id');
		$comment = $this->_request->getParam('comment');
		
		$model_user = new Model_User;
		$model_comment = new Model_Comment;
		$model_content = new Model_Contents;
		
		if($user = $model_user->getByToken($token)){
			$validator = new Zend_Validate_Db_RecordExists(
								array(
									"table"	=> $model_content->_name,
									'field' => 'id'
								)
							);
			if ( $validator->isValid($content_id)) {
				if ($model_comment->add($user['id'], $content_id, $comment)) {
					$this->reply['success'] = TRUE;
				}else{
					$this->reply['info'] = "Comment Failed";
				}
			}else{
				$this->reply['info'] = "Content not found";
			}
		}
	}
}
