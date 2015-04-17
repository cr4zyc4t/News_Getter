<?php
class Qplayvn_Forms_AddLink extends Zend_Form {
	function __construct($options = null) {
		$category_model = new Model_Category;
		$subcategory_model = new Model_Subcategory;
		$source_model = new Model_NewsSource;
		
		$YesNo_Options = array("Fasle", "True");
		
		$this->setAction('')
				->setMethod('POST')
				->setAttrib('class','form-horizontal');
		$id = $this->createElement('hidden', 'id',array(
															'value' => @$options['id'],
															)
									);
		$title = $this->createElement('text', 'name',array(
															'value' => @$options['name'],
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
        $subcategory=$this->createElement("select","sub_category_id",array(
														"class" => "form-control",
														"id" => "subcategory_select",
                                                        "label" => "Sub-Category",
                                                        "value" => @$options['sub_category_id'],
                                                   		"multioptions"=> $subcategory_model->selectOptions(@$options['category_id'])
														)
                        );
		$homepage = $this->createElement('text', 'home_page',array(
															'value' => @$options['home_page'],
															'label' => "Homepage",
															'class' => 'form-control'
															)
									);
		$list_content_xpath = $this->createElement('text', 'news_list_xpath',array(
															'value' => @$options['news_list_xpath'],
															'label' => "News List Xpath",
															'class' => 'form-control'
															)
									);
		$title_xpath = $this->createElement('text', 'title_xpath',array(
															'value' => @$options['title_xpath'],
															'label' => "Title Xpath",
															'class' => 'form-control'
															)
									);
		$title_from_content=$this->createElement("select","title_from_content",array(
														"class" => "form-control",
														"id" => "title_from_content_select",
                                                        "label" => "Title from Content",
                                                        "value" => @$options['title_from_content'],
                                                   		"multioptions"=> $YesNo_Options
														)
                        );
		$description_xpath = $this->createElement("text","description_xpath",array(
														"class" => "form-control",
                                                        "label" => "Description Xpath",
                                                        "value" => @$options['description_xpath'],
														)
                        );
		$icon_position = $this->createElement('text', 'icon_position',array(
															'value' => @$options['icon_position'],
															'label' => "Icon position",
															'class' => 'form-control'
															)
									);
		$time_xpath = $this->createElement('text', 'time_xpath',array(
															'value' => @$options['time_xpath'],
															'label' => "Time Xpath",
															'class' => 'form-control'
															)
									);
		$content_xpath = $this->createElement('text', 'content_xpath',array(
															'value' => @$options['content_xpath'],
															'label' => "Content Xpath",
															'class' => 'form-control'
															)
									);
		$tag_xpath = $this->createElement('text', 'tag_xpath',array(
															'value' => @$options['tag_xpath'],
															'label' => "Tag Xpath",
															'class' => 'form-control'
															)
									);
		$time_format = $this->createElement('text', 'time_format',array(
															'value' => @$options['time_format'],
															'label' => "Time Format",
															'class' => 'form-control'
															)
									);
		$processed = $this->createElement("select","processed",array(
														"class" => "form-control",
														"id" => "processed",
                                                        "label" => "Processed",
                                                        "value" => @$options['processed'],
                                                   		"multioptions"=> array("-1" => "Error", "0" => "Not run yet", "1" => "Already run")
														)
                        );
		$remove_tag_xpath = $this->createElement('textarea', 'remove_tag_xpath',array(
															'value' => @$options['remove_tag_xpath'],
															'label' => "Remove Tag Xpath",
															'class' => 'form-control',
															"rows" => 5
															)
									);
		$tag_from_desktop_version=$this->createElement("select","tag_from_desktop_version",array(
														"class" => "form-control",
														"id" => "tag_from_desktop_version",
                                                        "label" => "Tag from Desktop Verion",
                                                        "value" => @$options['tag_from_desktop_version'],
                                                   		"multioptions"=> $YesNo_Options
														)
                        );
		
		$submit = $this->createElement('submit','login',array ('label' => 'Submit' ,'class'	=>'btn btn-primary'));
		
		$this->addElement($id)
				->addElement($title)
				->addElement($sourcePage)
				->addElement($category)
				->addElement($subcategory)
				->addElement($url)
				->addElement($homepage)
				->addElement($list_content_xpath)
				->addElement($title_xpath)
				->addElement($title_from_content)
				->addElement($icon_position)
				->addElement($description_xpath)
				->addElement($time_xpath)
				->addElement($time_format)
				->addElement($content_xpath)
				->addElement($tag_xpath)
				->addElement($tag_from_desktop_version)
				->addElement($remove_tag_xpath)
				->addElement($processed)
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