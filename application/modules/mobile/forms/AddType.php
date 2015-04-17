<?php
class Admin_Forms_AddType extends Zend_Form {
	function __construct($options = null) {
		
		$this->setAction('')
				->setMethod('POST')
				->setAttrib('class','form-horizontal');
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
		$submit = $this->createElement('submit','login',array ('label' => 'Submit' ,'class'	=>'btn btn-primary'));
		
		
		$this->addElement($id)
			 ->addElement($title)
			 ->addElement($submit);
				
		$this->setDecorators(array('FormElements',array('HtmlTag',array('tag'	=> 'div','width'=>'100%')),'form'));
		$this->setElementDecorators(array(
										'ViewHelper',
										'Errors',
										'Description',
										array(	
											array('data'	=> 'HtmlTag'),
											array('tag'		=> 'div','class'	=> 'col-md-6')),
										array('label',
											array('class'	=> 'col-md-3 control-label')),
										array(
											array('row'	=> 'HtmlTag',),
											array('class'=>'form-group')
		        						)
									)
								);
		$submit->setDecorators(array(
								'ViewHelper',
								array(
									array('data'	=> 'HtmlTag'),
									array('tag'		=>	'div','class'	=> 'col-md-9 col-md-offset-3')
								),
								array(
									array('row'	=> 'HtmlTag'),
									array('tag'	=> 'div',"class"	=> "form-group"))
									));
	}
}