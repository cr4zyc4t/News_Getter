<?php
class Admin_Forms_UploadFile {
	public $_upload;
	function __construct($options = null) {
		$this->_upload = new Zend_File_Transfer;
		$this->_upload->setDestination(PUBLIC_PATH."/upload/");
	}
}