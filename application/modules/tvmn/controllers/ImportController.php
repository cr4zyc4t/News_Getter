<?php

class TVMN_ImportController extends Zend_Controller_Action
{
	public function init()
	{
		require_once 'toanvq.php';
	}
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
	
	function checkhttp($url) {
		$pos = strpos ($url ,"http" );
	    if ($pos === false || $pos !== 0 ) {
	        return false;
	    }
	    return true;
	}
	
	public function indexAction()
	{
		echo "Getting news for 'Món ngon mỗi ngày'<br/>";
		// Zend_Loader::loadFile(APPLICATION_PATH."/..\library\simple_html_dom.php");
		require 'default_simple_html_dom.php';
		
		$link_get_content_model = new Model_LinkGetContent;
		$news_model = new Model_News;
		$news_error_model = new Model_NewsError;
		
		$link_get_contents = $link_get_content_model->getLink($source_id = 2);
		
		$count = 0;
		foreach ($link_get_contents as $link_get_content) {
			$client = new Zend_Http_Client($link_get_content['url']);
				$config = array(
			        // "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
			        "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
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
				
				$nodes = $html->find("article.recipe-result");
				foreach ($nodes as $node) {
					$data = array();
					$data['source_id'] = $link_get_content['source_id'];
					$data['subcategory_id'] = $link_get_content['subcategory_id'];
					
					//GET TITLE
					$title_node = $node->getElementByTagName('a');
					$title = $title_node->text();
					$data['title'] = $this->removeDoubleSpace($title);
					
					// //GET LINK
					$data['url'] = $title_node->getAttribute('href');
					if (!$this->checkhttp($data['url'])){
						$data['url'] = $link_get_content['home_page'] . $data['url'];
					}
// 					
					// //GET COVER
					$data['icon'] = $title_node->getElementByTagName("figure.image > img")->getAttribute("src");
// 					
					// //GET NODE CONTENT START
					$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news",
																			'field' => 'url'
					));
					$validator_error_link = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news_error",
																						'field' => 'url'
					));
					if ( $validator_error_link->isValid($data['url']) ){
						if ($data['url'] && $data['title'] && $validator->isValid($data['url'])){
							$news_detail_client = new Zend_Http_Client($data['url']);
							$news_detail_client->setConfig(array(
						        // "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
						        "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
						        "timeout"		=> 10, 
						        "maxredirects" => 2
							));
							
							try {
								$news_body = $news_detail_client->request("GET")->getBody();
								$news_text = @mb_convert_encoding($news_body, 'utf-8', mb_detect_encoding($news_body));
								$news_text = @mb_convert_encoding($news_text, 'html-entities', 'utf-8');
								$news_text = @mb_convert_encoding($news_text, 'utf-8','html-entities');
			
								$news = str_get_html($news_text);
								
								$news_node = $news->getElementByTagName("div.c25l");

								//TITLE FROM CONTENT
								$title_node = $news_node->getElementByTagName("div.recipe-content-header h1");
								if ($title_node){
									$data['title'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($title_node->text()));
								}
								
								//DESCRIPTION
								$data['description'] = "";
								//TIME
								$data['time'] = date("Y-m-d H:i:s");
								
								//CONTENT
								$content_node = $news_node->find("div.subcl",1);
								$content_node->find(".c25r",0)->clear();
								if ($content_node){
									$data['content'] = $content_node->innertext();
									$data['content'] = $this->removeDoubleSpace($data['content']);
									$data['content'] = $this->removeStyle($data['content']);
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
		
		$id = $this->_request->getParam('id');
		
		require 'default_simple_html_dom.php';
		
		$link_get_content_model = new Model_LinkGetContent;
		$news_model = new Model_News;
		$news_error_model = new Model_NewsError;
		$subcategory_model = new Model_Subcategory;
		
		$link_get_content = $link_get_content_model->detail($id);
		
		$count = 0;
		
		try{
			$html = getHtmlNode($link_get_content['url']);
			
			$article = $html->find('article.hentry',0);
			//GET DATE
			$new_subcategory = array();
			$new_subcategory['type_id'] = 1;
			$new_subcategory['category_id'] = 54;
			
			if ($title_node = $article->find("h2.post-title",0)) {
				$new_subcategory['title'] = removeDoubleSpace($title_node->text());
				$url_node = $title_node->getElementByTagName("a");
			}
			//VALIDATE
			$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> $subcategory_model->_name,
																	"field" => 'title'
			));
			if (($validator->isValid($new_subcategory['title'])) && $url_node) {
				
				//COVER
				$cover_node = $article->getElementByTagName("meta");
				if ($cover_node) {
					$new_subcategory['icon'] = getFile($cover_node->content);
					$new_subcategory['avatar1'] = imgResize($new_subcategory['icon'], -1, 128);
					$new_subcategory['avatar2'] = imgResize($new_subcategory['icon'], -1, 250);
					$new_subcategory['avatar3'] = imgResize($new_subcategory['icon'], -1, 300);
				}
				
				//DESCRIPTION
				$desc_node = $article->find("div.post-body",0);
				if ($desc_node) {
					$new_subcategory['desc'] = removeDoubleSpace($desc_node->text());
				}
				
				$subcategory_id = $subcategory_model->insert($new_subcategory);
				arr_dump($new_subcategory);
				
				$html = getHtmlNode($url_node->href);
				
				$article_nodes = $html->find("div.post-body",0)->find("tr");
				if (count($article_nodes) == 25) {
					for ($i=1; $i < 24; $i=$i+2) { 
						$title_node = $article_nodes[$i];
						$content_node = $article_nodes[$i+1];
						
						$new_content = array();
						$new_content['source_id'] = $link_get_content['source_id'];
						$new_content['subcategory_id'] = $subcategory_id;
						
						$new_content['title'] = $title_node->text();
						$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> $news_model->_name,
																				"field" => 'title'
						));
						
						if ($validator->isValid($new_content['title'])) {
							$new_content['icon'] = getFile($content_node->find("td img",0)->src);
							$new_content['avatar1'] = imgResize($new_content['icon'], -1, 128);
							$new_content['avatar2'] = imgResize($new_content['icon'], -1, 250);
							$new_content['avatar3'] = imgResize($new_content['icon'], -1, 300);
							
							$new_content['content'] = removeDoubleSpace( $content_node->find("td",1)->innertext() );
							
							$news_model->insert($new_content);
							$count++;
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