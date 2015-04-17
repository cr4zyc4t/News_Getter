<?php
class Admin_Forms_AddPage extends Zend_Form {
	function __construct($options = null) {
		
		// $this->_upload = new Zend_File_Transfer;
        // $this->_upload->setDestination(APPLICATION_PATH.'/../assets/upload/');
		
		$this->setAction('')
				->setMethod('POST')
				->setAttrib('class','form-horizontal')
				->setAttrib('enctype','multipart/form-data');
		$id = $this->createElement('hidden', 'id',array(
														'value' => @$options['id'],
														)
									);
		$title = $this->createElement('text', 'title',array(
															'value' => @$options['title'],
															'label' => "Title",
															'class' => 'form-control'
															)
									);
		$title->setRequired ( true );
		$homepage = $this->createElement('text', 'homepage',array(
															'value' => @$options['homepage'],
															'label' => "Homepage",
															'class' => 'form-control'
															)
									);
		$icon = $this->createElement('file', 'icon',array(
															'label' => "Icon",
															'accept' => ".png,.jpg,.jpeg,.bmp",
															'class' => 'form-control'
															)
									);
		$module = $this->createElement('text', 'module_name',array(
															'value' => @$options['module_name'],
															'label' => "Module Name",
															'class' => 'form-control'
															)
									);
		
		$submit = $this->createElement('submit','login',array ('label' => 'Submit' ,'class'	=>'btn btn-primary'));
		
		
		$this->addElement($id)
			 ->addElement($title)
			 ->addElement($homepage)
			 ->addElement($icon)
			 ->addElement($module)
			 ->addElement($submit);
				
		$this->setDecorators(array('FormElements',array('HtmlTag',array('tag'	=> 'div','width'=>'100%')),'form'));
		// $this->setElementDecorators(array(
										// 'ViewHelper',
										// 'Errors',
										// 'Description',
										// array(	
											// array('data'	=> 'HtmlTag'),
											// array('tag'		=> 'div','class'	=> 'col-md-6')
											// ),
										// array('label',
											// array('class'	=> 'col-md-3 control-label')
											// ),
										// array(
											// array('row'	=> 'HtmlTag',),
											// array('class'=>'form-group')
		        							// )
										// )
									// );
		// $submit->setDecorators(array(
								// 'ViewHelper',
								// array(
									// array('data'	=> 'HtmlTag'),
									// array('tag'		=>	'div','class'	=> 'col-md-9 col-md-offset-3')
								// ),
								// array(
									// array('row'	=> 'HtmlTag'),
									// array('tag'	=> 'div',"class"	=> "form-group"))
									// )
								// );
	}
}