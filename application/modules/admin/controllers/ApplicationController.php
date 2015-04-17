<?php

class Admin_ApplicationController extends Zend_Controller_Action
{
	public function init()
	{
		$option=array(
	        "layout" => "admin",
	        "layoutPath" => APPLICATION_PATH."/layouts/scripts/"
      	);
      	Zend_Layout::startMvc($option);
        $this->view->pageTitle = "Amobi - toanvq";
        include 'toanvq.php';
	}
	
	public function appAction()
	{
		$id = $this->_request->getParam('id');
		
		$this->view->navibar = navibar(2,3);
		$this->view->pageSubtitle = "Application";
		$this->view->pageHeader = "Link get contents";
		
		$linkgetcontent = new Model_LinkGetContent;
		$this->view->tableData = $linkgetcontent->tableData();
		// $this->view->type = $type;
	}
	
	public function addlinkAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$link_id = $this->_request->getParam('id');
		
		$this->view->navibar = navibar(2,3);
		$this->view->pageHeader = "Link get content";
		$this->view->pageSubtitle = "Add new";
		
		$link = new Model_LinkGetContent;
		if ($link_id && ($link_id != -1)) {
			$link_detail = $link->detail($link_id);
		}else{
			$link_detail = $_POST;
		}
		
		Zend_Loader::loadClass("admin_forms_AddLink");
		$form = new Admin_Forms_AddLink($link_detail);
		
		if($this->_request->isPost()){
            if($form->isValid($_POST)){
                try{
                	// arr_dump($_POST);
                	$data = $form->getValues();
					// arr_dump($data);
					unset($data['id']);
					unset($data['category_id']);
					
					if ($link_id) {
						$link->update($data, "id=$link_id");
					} else {
						$zend_validate = new Zend_Validate_Db_NoRecordExists(array('table' => 'link_get_content', 'field' => 'url'));
						if ($zend_validate->isValid($data['url'])) {
							$link->insert($data);
						}
					}
					
					
                    $this->_redirect('/admin/resource/links');
                }catch (Exception $e){
                	echo $e;
                }
            }
        }
		
		echo $form; 
	}

	public function subcategoryselectAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
		
		$category_id = $this->_request->getParam('ctg');
		$subcategory = new Model_Subcategory;
		$options = $subcategory->selectOptions($category_id);
		
		$html = "";
		foreach ($options as $key => $value) {
			$html.= "<option value=\"$key\" label=\"$value\">$value</option>";
		}
		echo $html;
	}
	
	public function deletelinkAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
		
		$reply = array();
		$reply['code'] = 907;
		$reply['desc'] = "Unknown Error";
		
		$category_id = $this->_request->getParam('id');
		if ($category_id) {
			$category = new Model_LinkGetContent;
			$category->delete("id=$category_id");
			
			$reply['code'] = 0;
			$reply['desc'] = "Success";
		}
		echo json_encode($reply);
	}
	
	public function doaddcategoryAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$type = $this->_request->getParam('type');
		$category_id = $this->_request->getParam('id');
		if ($type) {
			$data = array();
			$data['title'] = $this->_request->getParam('title');
			$data['type_id'] = $this->_request->getParam('type');
			$data['sort'] = $this->_request->getParam('sort');
			
			$category = new Model_Category;
			if ($category_id) {
				$category->update($data, "id=$category_id");
			}else{
				$category->insert($data);
			}
			$this->_redirect("/admin/manage/source?type=$type");
		}
	}
	
	public function getcontentAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
		
		$this->view->navibar = navibar(2,3);
		$this->view->pageHeader = "Get Contents";
		$this->view->pageSubtitle = "from link";
		
		$linkgetcontent = new Model_LinkGetContent;
		$this->view->tableData = $linkgetcontent->tableData();
	}
	
	public function typesAction()
	{
		$this->view->navibar = navibar(2,2);
		$this->view->pageHeader = "Content Types";
		// $this->view->pageSubtitle = "Content Types";
		
		$type_model = new Model_Bigtype;
		$this->view->tableData = $type_model->tableData();
		// $this->view->type = $type;
	}
	
	public function addtypeAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$link_id = $this->_request->getParam('id');
		
		$this->view->navibar = navibar(2,2);
		$this->view->pageHeader = "Content Type";
		$this->view->pageSubtitle = "Add new";
		
		$link = new Model_Bigtype;
		$link_detail = $link->detail($link_id?$link_id:-1);
		
		Zend_Loader::loadClass("admin_forms_AddType");
		$form = new Admin_Forms_AddType($link_detail);
		
		if($this->_request->isPost()){
            if($form->isValid($_POST)){
                try{
                	$data = $form->getValues();
					unset($data['id']);
					
					if ($link_id) {
						$link->update($data, "id=$link_id");
					} else {
						$zend_validate = new Zend_Validate_Db_NoRecordExists(array('table' => $link->_name, 'field' => 'title'));
						if ($zend_validate->isValid($data['title'])) {
							$link->insert($data);
						}
					}
					
                    $this->_redirect('/admin/resource/types');
                }catch (Exception $e){
                	echo $e;
                }
            }
        }
		
		echo $form; 
	}

	public function deletetypeAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
		
		$reply = array();
		$reply['code'] = 907;
		$reply['desc'] = "Unknown Error";
		
		$category_id = $this->_request->getParam('id');
		if ($category_id) {
			$category = new Model_Bigtype;
			$category->delete("id=$category_id");
			
			$reply['code'] = 0;
			$reply['desc'] = "Success";
		}
		echo json_encode($reply);
	}
	
	public function pagesAction()
	{
		$this->view->navibar = navibar(2,1);
		$this->view->pageHeader = "Resource Page";
		// $this->view->pageSubtitle = "Content Types";
		
		$model = new Model_NewsSource;
		$this->view->tableData = $model->tableData();
	}
	
	public function addpageAction()
	{
		// $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		
		$id = $this->_request->getParam('id');
		
		$this->view->navibar = navibar(2,1);
		$this->view->pageHeader = "Content Type";
		$this->view->pageSubtitle = "Add new";
		
		$model = new Model_NewsSource;
		$detail = $model->detail($id?$id:-1);
		
		Zend_Loader::loadClass("admin_forms_AddPage");
		$form = new Admin_Forms_AddPage($detail);
		
		if($this->_request->isPost()){
            if($form->isValid($_POST)){
                try{
                	$path = "assets/upload/";
					$icon_path = "";
					$valid_formats = array("jpg", "png", "bmp","jpeg");
					$name = $_FILES['icon']['name'];
					$size = $_FILES['icon']['size'];

					if (strlen($name)) {
						$name_arr = explode(".", $name);
						$ext = array_pop($name_arr);
						if (in_array($ext, $valid_formats)) {
							if ($size < (2048 * 2048)) {
								$actual_image_name = uniqid(time()).".". $ext;
								$tmp = $_FILES['icon']['tmp_name'];
								if (move_uploaded_file($tmp, $path . $actual_image_name)) {
									$icon_path = "/".$path.$actual_image_name;
								} else
									echo "Upload failed";
							} else
								echo "Image file size is too large!";
						} else
							echo "Invalid file format..";
					}
                	
					$data = $form->getValues();
					unset($data['id']);
					unset($data['icon']);
					if ($icon_path != "") {
						$data['icon'] = $icon_path;
					}
					
					if ($id) {
						$model->update($data, "id=$id");
					} else {
						$zend_validate = new Zend_Validate_Db_NoRecordExists(array('table' => $model->_name, 'field' => 'title'));
						if ($zend_validate->isValid($data['title'])) {
							$model->insert($data);
						}
					}
					$this->_redirect('/admin/resource/pages');
                }catch (Exception $e){
                	echo $e;
                }
            }
        }
		
		echo $form; 
	}

	public function deletepageAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
		
		$reply = array();
		$reply['code'] = 907;
		$reply['desc'] = "Unknown Error";
		
		$id = $this->_request->getParam('id');
		if ($id) {
			$model = new Model_NewsSource;
			$model->delete("id=$id");
			
			$reply['code'] = 0;
			$reply['desc'] = "Success";
		}
		echo json_encode($reply);
	}
}