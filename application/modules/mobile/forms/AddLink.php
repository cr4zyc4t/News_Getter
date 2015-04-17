<?php
class Admin_Forms_AddLink extends Zend_Form {
	function __construct($options = null) {
		$category_model = new Model_Category;
		$subcategory_model = new Model_Subcategory;
		$source_model = new Model_NewsSource;
		
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
		$url = $this->createElement('text', 'url',array(
															'value' => @$options['url'],
															'label' => "URL",
															'class' => 'form-control'
															)
									);
		$sourcePage=$this->createElement("select","source_id",array(
														"class" => "form-control",
                                                        "label" => "Source Page",
                                                        "value" => @$options['source_id'],
                                                   		"multioptions"=> $source_model->selectOptions()
														)            
                        );
		$category=$this->createElement("select","category_id",array(
														"class" => "form-control",
														"id" => "category_select",
                                                        "label" => "Category",
                                                        "value" => @$options['category_id'],
                                                   		"multioptions"=> $category_model->selectOptions(TRUE)
														)
                        );
        $subcategory=$this->createElement("select","subcategory_id",array(
														"class" => "form-control",
														"id" => "subcategory_select",
                                                        "label" => "Sub-Category",
                                                        "value" => @$options['subcategory_id'],
                                                   		"multioptions"=> $subcategory_model->selectOptions()
														)
                        );
		$submit = $this->createElement('submit','login',array ('label' => 'Submit' ,'class'	=>'btn btn-primary'));
		
		
		$this->addElement($id)
				->addElement($title)
				->addElement($sourcePage)
				->addElement($url)
				->addElement($category)
				->addElement($subcategory)
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