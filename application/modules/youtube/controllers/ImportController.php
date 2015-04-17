<?php

class Youtube_ImportController extends Zend_Controller_Action
{
	public function init()
	{
		include_once 'toanvq.php';
	}
	private function getParamFromUrl($url, $param)
	{
		$url_parsed = parse_url($url);
		if (isset($url_parsed['query'])) {
			parse_str($url_parsed['query'], $url_part);
			if (isset($url_part[$param])) {
				return $url_part[$param];
			}
		}
		return FALSE;
	}
	
	// public function playlistAction()
	// {
		// require 'default_simple_html_dom.php';
		// $this->_helper->viewRenderer->setNoRender();
// 		
		// $news_model = new Model_News;
// 		
		// $subcategory_id = $this->_request->getParam('subcategory_id');
		// $url = $this->_request->getParam('url');
		// $subcategory = new Model_Subcategory;
		// $subcategory = $subcategory->detail($subcategory_id);
// 		
		// if ($this->checkhttp($url) && $subcategory) {
			// $client = new Zend_Http_Client($url);
				// $config = array(
			        // // "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
			        // "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
			        // "timeout"		=> 10, 
			        // "maxredirects"	=> 1
				// );
			// $client->setConfig($config);
// 			
			// try{
				// $body = $client->request("GET")->getBody();
				// $html_text = @mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
				// $html_text = @mb_convert_encoding($html_text, 'html-entities', 'utf-8');
				// $html_text = @mb_convert_encoding($html_text, 'utf-8','html-entities');
				// $html = str_get_html($html_text);
// 				
				// $nodes = $html->find("tr.yt-uix-tile");
// 				
				// $count = 0;
				// foreach ($nodes as $node) {
					// $data = array();
// 					
					// $video_id = $this->getParamFromUrl($node->getElementByTagName(".pl-video-title a")->getAttribute("href"), 'v');
					// $data['url'] = "http://www.youtube.com/watch?v=$video_id";
					// $data['icon'] = $node->getElementByTagName(".pl-video-thumbnail img")->getAttribute("src");
// 					
					// // //GET NODE CONTENT START
					// $validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news",
																			// 'field' => 'url'
					// ));
					// $validator_error_link = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news_error",
																						// 'field' => 'url'
					// ));
					// if ($video_id && $validator_error_link->isValid($data['url']) && $validator->isValid($data['url'])) {
// 						
						// $client = new Zend_Http_Client("http://gdata.youtube.com/feeds/api/videos/".$video_id);
							// $config = array(
						        // "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
						        // "timeout"		=> 10,
						        // "maxredirects"	=> 1
							// );
						// $client->setConfig($config);
// 						
						// try{
							// $content_body = $client->request("GET")->getBody();
							// $content_html_text = @mb_convert_encoding($content_body, 'utf-8', mb_detect_encoding($content_body));
							// $content_html_text = @mb_convert_encoding($content_html_text, 'html-entities', 'utf-8');
							// $content_html_text = @mb_convert_encoding($content_html_text, 'utf-8','html-entities');
							// $content_html = str_get_html($content_html_text);
// 							
							// $data['title'] = $content_html->getElementByTagName("title")->text();
							// $data['description'] = $content_html->getElementByTagName("content")->text();
							// $data['subcategory_id'] = $subcategory_id;
							// $data['time'] = $content_html->getElementByTagName("updated")->text();
							// $data['time'] = date('Y-m-d H:i:s',strtotime($data['time']));
							// $data['content'] = $data['url'];
// 							
							// try {
								// if ($data['title'] && $data['content']){
									// $news_model->insert($data);
									// $count++;
								// }else{
									// $news_error_model->insert(array("url"	=> $data['url']));
								// }
							// } catch (Exception $e) {
								// echo "3|Loi khi luu nội dung bài báo";
								// die;
							// }
						// }catch(exception $e){
							// echo $e;
						// }
					// }
				// }
				// // echo "$count article imported";
				// $this->_redirect("/admin/manage/listcontent?subcategory_id=$subcategory_id");
			// }catch(exception $e){
				// echo $e;
			// }
		// }
	// }

	public function playlist2Action()
	{
		Zend_Loader::loadClass("simpleImage");
		
		$this->_helper->viewRenderer->setNoRender();
		
		$reply = array();
		$success = FALSE;
		$info = "";
		
		$subcategory_id = $this->_request->getParam('subcategory_id');
		$url = $this->_request->getParam('url');
		$news_model = new Model_News;
		
		$subcategory_model = new Model_Subcategory;
		$subcategory = $subcategory_model->detail($subcategory_id);
		
		$pos = strpos ($url ,"http://gdata.youtube.com" );
		
		$url_type = 'playlist';
	    if ($pos === false || $pos !== 0 ) {
	        if( $list_id = getParamFromUrl($url, "list") ){
	        	$url = "http://gdata.youtube.com/feeds/api/playlists/$list_id?alt=json&max-results=10";
				$url_type = 'playlist';
	        }elseif($video_id = getParamFromUrl($url, "v")) {
	        	$url = "http://gdata.youtube.com/feeds/api/videos/$video_id?alt=json";
				$url_type = 'video';
	        }else{
	        	$url_params = explode("/", $url);
				if (count($url_params) > 4) {
					if (($url_params[3] == "channel") || ( $url_params[3] == "user")) {
						$url_type = 'playlist';
						$url = "http://gdata.youtube.com/feeds/api/videos?author=$url_params[4]&alt=json&max-results=10";
					}else{
						$url_type = '';
			        	$success = FALSE;
						$info = "Bad url";
					}
				}else{
					$url_type = '';
		        	$success = FALSE;
					$info = "Invalid url";
				}
	        }
	    }
		
		if (checkhttp($url) && $subcategory && $url_type) {
			try{
				$body = httpRequest($url);
				$body = json_decode($body);
				// arr_dump($body->feed); die;
				
				$entry = array();
				if ($body) {
					
					if ($url_type == 'playlist') {
						$reply['total'] = $body->feed->{'openSearch$totalResults'}->{'$t'};
						
						foreach ($body->feed->{'link'} as $value) {
							if ($value->rel == 'next') {
								$reply['next'] = $value->href;
							}
						}
						
						// THUMBNAIL UPDATE FOR SUBCATEGORY
						$data = array();
						if (property_exists($body->feed, 'media$group')) {
							$list_thumbnails = $body->feed->{'media$group'}->{'media$thumbnail'};
							if(!$subcategory['icon'] && isset($list_thumbnails[2]))
								$data['icon'] = getFile($list_thumbnails[2]->url);
							if(!$subcategory['avatar1'] && isset($list_thumbnails[0]))
								$data['avatar1'] = getFile($list_thumbnails[0]->url);
							if(!$subcategory['avatar2'] && isset($list_thumbnails[1]))
								$data['avatar2'] = getFile($list_thumbnails[1]->url);
							if(!$subcategory['avatar3'] && isset($list_thumbnails[2]))
								$data['avatar3'] = getFile($list_thumbnails[2]->url);
							if(count($data))
								$subcategory_model->update($data, "id = $subcategory_id");
						}
						
						$entry = $body->feed->entry;
					}elseif ($url_type == 'video') {
						$reply['total'] = 1;
						
						$entry = array($body->entry);
					}
					
					$count = 0;
					$conflict_count = 0;
					$error_count = 0;
					foreach ($entry as $video_info) {
						$data = array();
						$links = $video_info->{'link'};
						foreach ($links as $link) {
							if ($link->rel == 'alternate') {
								$data['content'] = $data['url'] = $link->href;
								continue;
							}
						}
						if (!isset($data['url'])) {
							continue;
						}
						$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news",
																				'field' => 'url',
																				'exclude' => "subcategory_id = $subcategory_id"
						));
						if ($validator->isValid($data['url'])) {
							$data['title'] = $video_info->title->{'$t'};
							if ($data['title'] == 'Deleted video') {
								$error_count++;
								continue;
							}
							if (property_exists($video_info, "content")) {
								$data['description'] = removeDoubleSpace( $video_info->content->{'$t'} );
							}else{
								$error_count++;
								continue;
							}
							
							$data['subcategory_id'] = $subcategory_id;
								$published = strtotime($video_info->published->{'$t'});
								$updated = strtotime($video_info->updated->{'$t'});
							if ($updated) {
								$data['time'] = date('Y-m-d H:i:s', $updated);
							}else{
								$data['time'] = date('Y-m-d H:i:s', $published);
							}
							
							if (property_exists($video_info, "author")) {
								$data['author'] = @$video_info->author->name->{'$t'};
								if ((!$data['author']) && is_array($video_info->author) ) {
									$data['author'] = @$video_info->author[0]->name->{'$t'};
								}
							}
							
							$thumbnails = $video_info->{'media$group'}->{'media$thumbnail'};
								$data['icon'] = getFile($thumbnails[0]->url);
								if ($data['icon']) {
									$data['avatar1'] = imgResize($data['icon'], -1, 128);
									$data['avatar2'] = imgResize($data['icon'], -1, 250);
									$data['avatar3'] = imgResize($data['icon'], -1, 300);
								}
							
							$data['source_id'] = 3;
								
							$news_model->insert($data);
							// arr_dump($data); die;
							
							$count++;
						}else{
							$conflict_count++;
						}
					}
					$success = TRUE;
					$reply['count'] = $count;
					$reply['conflict'] = $conflict_count;
					$reply['error'] = $error_count;
				}else{
					$info = "Invalid Url";
				}
			}catch(exception $e){
				$info = print_r($e);
			}
		}

		$reply['success'] = $success;
		$reply['info'] = $info;
		echo json_encode($reply);
	}

	public function previewAction()
	{
		
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
					if (($validator_error_link->isValid($data['url'])) && ($count < 6)){
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
}