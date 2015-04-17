<?php

class SKBB_ImportController extends Zend_Controller_Action
{
	
	private function removeDoubleSpace($string){
    	mb_internal_encoding('UTF-8');		
    	$string = str_replace(chr("0xC2").chr("0xA0")," ",$string);
    	$string = str_replace("&nbsp;", " ", $string);
    	$string = str_replace("&nbsp", " ", $string);
    	$string = preg_replace("{[ \t]+}", ' ',$string);	
    	$string = trim($string);
    	$string = preg_replace("/<br[^>]*>([ \t])*/","<br/>",$string);
    	$string = preg_replace("/<br\/>(<br\/>)+/","<br/>",$string);
    	$string = preg_replace("/^<br\/>/","",$string);
//    	$string = str_replace("<br/><imgsunnet>", "<imgsunnet>", $string);
//    	$string = str_replace("</imgsunnet><br/>", "</imgsunnet>", $string);
    	return trim($string);
    }
	
	private function removeStyle($string){
    	return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $string);
    }
	
	private function fixImgWidth($string){
    	return preg_replace('/<img/', '<img style="width:100% !important;" /',$string);
    }
	
	function checkhttp($url) {
		$pos = strpos ($url ,"http" );
	    if ($pos === false || $pos !== 0 ) {
	        return false;
	    }
	    return true;
	}
	
	public function indexAction()
	{
		echo "Getting news for 'Sức khỏe bà bầu'<br/>";
		// Zend_Loader::loadFile(APPLICATION_PATH."/..\library\simple_html_dom.php");
		require 'default_simple_html_dom.php';
		
		$link_get_content_model = new Model_LinkGetContent;
		$news_model = new Model_News;
		$news_error_model = new Model_NewsError;
		
		$link_get_contents = $link_get_content_model->getLink($source_id = 1);
		
		$count = 0;
		
		foreach ($link_get_contents as $link_get_content) {
			if ($count > 6) {
				break;
			}
			$client = new Zend_Http_Client($link_get_content['url']);
				$config = array(
			        "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
			        // "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
			        "timeout"		=> 10, 
			        "maxredirects"	=> 1
				);
			$client->setConfig($config);
			
			try{
				$body = $client->request("GET")->getBody();
				$html_text = @mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
				$html_text = @mb_convert_encoding($html_text, 'html-entities', 'utf-8');
				$html_text = @mb_convert_encoding($html_text, 'utf-8','html-entities');
				$html = str_get_html($html_text);
				
				$nodes = $html->find(".t-top");
				foreach ($nodes as $node) {
					if ($count > 6) {
						break;
					}
					$data = array();
					$data['source_id'] = $link_get_content['source_id'];
					$data['subcategory_id'] = $link_get_content['subcategory_id'];
					
					//GET TITLE
					$title_node = $node->getElementByTagName('.t-top-r h3 a');
					$title = $title_node->text();
					$data['title'] = $title;
					
					//GET LINK
					$data['url'] = $title_node->getAttribute('href');
					if (!$this->checkhttp($data['url'])){
						$data['url'] = $link_get_content['home_page'] . $data['url'];
					}
					
					//GET COVER
					$data['icon'] = $node->getElementByTagName(".t-top-l .img-thumb img")->getAttribute("src");
					
					//GET NODE TITLE FINISH
					//GET NODE CONTENT START
					$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news",
																			'field' => 'url'
					));
					$validator_error_link = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news_error",
																						'field' => 'url'
					));
					if ($validator_error_link->isValid($data['url'])){
						
						if ($data['url'] && $data['title'] && $validator->isValid($data['url'])){
							$news_detail_client = new Zend_Http_Client($data['url']);
							$news_detail_client->setConfig(array(
						        "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
						        // "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
						        "timeout"		=> 10, 
						        "maxredirects" => 1
							));
							try {
								$news_body = $news_detail_client->request("GET")->getBody();
								$news_text = @mb_convert_encoding($news_body, 'utf-8', mb_detect_encoding($news_body));
								$news_text = @mb_convert_encoding($news_text, 'html-entities', 'utf-8');
								$news_text = @mb_convert_encoding($news_text, 'utf-8','html-entities');
			
								$news = str_get_html($news_text);
								$news_node = $news->getElementByTagName("div.title_news");
								
								//TITLE FROM CONTENT
								$title_node = $news_node->getElementByTagName("h1");
								if ($title_node){
									$data['title'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($title_node->text()));
								}
								
								//DESCRIPTION
								$data['description'] = "";
								$description_node = $news_node->getElementByTagName("div.desc");
								if ($description_node){
									$data['description'] = $this->removeDoubleSpace($description_node->text());
								}
								
								//TIME
								$data['time'] = date("Y-m-d H:i:s");
								// $timesource_node = $news->find($link_get_content['time_xpath'],0);
								// if ($timesource_node){
									// if ($link_get_content['source_id'] == 27){
										// $date = new Zend_Date();
									// }else{
										// $date = new Zend_Date($this->removeDoubleSpace($timesource_node->text()),$link_get_content['time_format']);
									// }
									// if (in_array($link_get_content['source_id'], array(26))){
										// $date->setMinute(Zend_Date::now()->getMinute());
										// $date->setHour(Zend_Date::now()->getHour());
										// $date->setMilliSecond(Zend_Date::now()->getMilliSecond());
									// }
									// $data['time'] = $date->toString('yyyy-MM-dd HH:mm:ss');
								// }
								// if ($link_get_content['tag_xpath']){
									// if (!$link_get_content['tag_from_desktop_version']){
										// $tag_node = $news->find($link_get_content['tag_xpath']);
									// }else{
										// $client = new Zend_Http_Client(str_replace("http://m.", "http://", $link));
										// $client->setConfig(array(
									        // "timeout"		=> 10, 
									        // "maxredirects"	=> 2
										// ));
										// $tag_body = $client->request()->getBody();
// 										
										// $tag_text = @mb_convert_encoding($tag_body, 'utf-8', mb_detect_encoding($tag_body));
										// $tag_text = @mb_convert_encoding($tag_text, 'html-entities', 'utf-8');
										// $tag_text = @mb_convert_encoding($tag_text, 'utf-8','html-entities');
// 										
										// $tag_html = str_get_html($tag_text);
										// $tag_node = $tag_html->find($link_get_content['tag_xpath']);
// 										
										// if ($link_get_content['home_page'] == "http://m.danviet.vn"){
											// $timesource_node = $tag_html->find("div.date",0);
											// $date = new Zend_Date($this->removeDoubleSpace($timesource_node->text()),$link_get_content['time_format']);
											// $data['time'] = $date->toString('yyyy-MM-dd HH:mm:ss');
										// }
									// }
									// $tag_list = array();
									// if ($tag_node){
										// foreach ($tag_node as $tag){
											// $tag_list[] = $this->removeDoubleSpace($tag->text());
										// }
										// $data['tag'] = implode(";", $tag_list);
									// }
								// }
								// if ($link_get_content['remove_tag_xpath']){
									// $tag_list = explode("\r\n", $link_get_content['remove_tag_xpath']);
									// $tag_list = array_reverse($tag_list);
									// foreach ($tag_list as $tag) {
										// $remove_tag = $news->find($tag,0);
										// if ($remove_tag){
											// $remove_tag->clear();
										// }
									// }
								// }
								$content_node = $news_node->getElementByTagName("div.body");
								if ($content_node){
									
									//FIX IMG LINK
									$content_imgs = $content_node->find("img");
									foreach ($content_imgs as $content_img) {
										if ( !$this->checkhttp($content_img->getAttribute("src")) ) {
											$content_img->setAttribute("src", $link_get_content['home_page'] .$content_img->getAttribute("src"));
										}
										// $content_img->setAttribute("style","width:100% !important;");
									}
									//Alternate url
									foreach ($content_node->find('a') as $link_node) {
										$link_node->setAttribute("href", "#");
									}
									
									$data['content'] = $this->removeDoubleSpace($content_node->innertext());
									$data['content'] = $this->removeStyle($data['content']);
									$data['content'] = $this->fixImgWidth($data['content']);
								}
								try {
									if ($data['content']){
										$news_model->insert($data);
										$count++;
									}else{
										$news_error_model->insert(array("url"	=> $data['url']));
									}
								} catch (Exception $e) {
									echo "3|Loi khi luu nội dung bài báo";
									die;
								}
							}catch(exception $e){
								echo "4|Loi khi load trang bao chi tiết";
								die;
							}
						}
					}
					echo "<pre>";
					print_r($data);
					echo "</pre>";
				}
			}catch(exception $e){
				echo "<br/>Error:<br/>".$e;
			}
		}
		echo "$count article imported";
	}


	public function getcontentAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		require 'default_simple_html_dom.php';
		
		$id = $this->_request->getParam('id');
		
		$link_get_content_model = new Model_LinkGetContent;
		$news_model = new Model_News;
		$news_error_model = new Model_NewsError;
		
		$link_get_content = $link_get_content_model->detail($id);
		
		$count = 0;
		$client = new Zend_Http_Client($link_get_content['url']);
			$config = array(
		        "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
		        "timeout"		=> 10, 
		        "maxredirects"	=> 1
			);
		$client->setConfig($config);
		
		try{
			$body = $client->request("GET")->getBody();
			$html_text = @mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
			$html_text = @mb_convert_encoding($html_text, 'html-entities', 'utf-8');
			$html_text = @mb_convert_encoding($html_text, 'utf-8','html-entities');
			$html = str_get_html($html_text);
			
			$nodes = $html->find(".t-top");
			foreach ($nodes as $node) {
				if ($count > 6) {
					break;
				}
				$data = array();
				$data['source_id'] = $link_get_content['source_id'];
				$data['subcategory_id'] = $link_get_content['subcategory_id'];
				
				//GET TITLE
				$title_node = $node->getElementByTagName('.t-top-r h3 a');
				$title = $title_node->text();
				$data['title'] = $title;
				
				//GET LINK
				$data['url'] = $title_node->getAttribute('href');
				if (!$this->checkhttp($data['url'])){
					$data['url'] = $link_get_content['home_page'] . $data['url'];
				}
				
				//GET COVER
				$data['icon'] = $node->getElementByTagName(".t-top-l .img-thumb img")->getAttribute("src");
				
				//GET NODE TITLE FINISH
				//GET NODE CONTENT START
				$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news",
																		'field' => 'url'
				));
				$validator_error_link = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news_error",
																					'field' => 'url'
				));
				if ($validator_error_link->isValid($data['url'])){
					
					if ($data['url'] && $data['title'] && $validator->isValid($data['url'])){
						$news_detail_client = new Zend_Http_Client($data['url']);
						$news_detail_client->setConfig(array(
					        "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
					        // "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
					        "timeout"		=> 10, 
					        "maxredirects" => 1
						));
						try {
							$news_body = $news_detail_client->request("GET")->getBody();
							$news_text = @mb_convert_encoding($news_body, 'utf-8', mb_detect_encoding($news_body));
							$news_text = @mb_convert_encoding($news_text, 'html-entities', 'utf-8');
							$news_text = @mb_convert_encoding($news_text, 'utf-8','html-entities');

							$news = str_get_html($news_text);
							$news_node = $news->getElementByTagName("div.title_news");
							
							//TITLE FROM CONTENT
							$title_node = $news_node->getElementByTagName("h1");
							if ($title_node){
								$data['title'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($title_node->text()));
							}
							
							//DESCRIPTION
							$data['description'] = "";
							$description_node = $news_node->getElementByTagName("div.desc");
							if ($description_node){
								$data['description'] = $this->removeDoubleSpace($description_node->text());
							}
							
							//TIME
							$data['time'] = date("Y-m-d H:i:s");
							
							$content_node = $news_node->getElementByTagName("div.body");
							if ($content_node){
								
								//FIX IMG LINK
								$content_imgs = $content_node->find("img");
								foreach ($content_imgs as $content_img) {
									if ( !$this->checkhttp($content_img->getAttribute("src")) ) {
										$content_img->setAttribute("src", $link_get_content['home_page'] .$content_img->getAttribute("src"));
									}
									// $content_img->setAttribute("style","width:100% !important;");
								}
								//Alternate url
								foreach ($content_node->find('a') as $link_node) {
									$link_node->setAttribute("href", "#");
								}
								
								$data['content'] = $this->removeDoubleSpace($content_node->innertext());
								$data['content'] = $this->removeStyle($data['content']);
								$data['content'] = $this->fixImgWidth($data['content']);
							}
							try {
								if ($data['content']){
									$news_model->insert($data);
									// arr_dump($data);
									$link_get_content_model->update(array('last_run' => date('Y-m-d H:i:s')), "id=$id");
									$count++;
								}else{
									$news_error_model->insert(array("url"	=> $data['url']));
								}
							} catch (Exception $e) {
								echo "3|Loi khi luu nội dung bài báo";
								die;
							}
						}catch(exception $e){
							echo "4|Loi khi load trang bao chi tiết";
							die;
						}
					}
				}
			}
		}catch(exception $e){
			echo "<br/>Error:<br/>".$e;
		}
		echo $count;
	}
}