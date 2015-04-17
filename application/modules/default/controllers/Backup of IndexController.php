<?php

class IndexController extends Zend_Controller_Action
{
	public function init()
	{
		$option=array(
	        "layout" => "layout",
	        "layoutPath" => APPLICATION_PATH."/layouts/scripts/"
      	);
      	Zend_Layout::startMvc($option);
        $this->view->headTitle("QHOnline - Zend Layout");
		
		$model_category = new Model_Category;
		$categories = $model_category->getListCategory(1,1000);
		$categories = array_merge(
			array(
				array(
					"id" => -1,
					"title" => "Nổi bật",
					"url" => "/noi-bat.html"
				),
				array(
					"id" => -2,
					"title" => "Tin mới",
					"url" => "/tin-moi.html"
				)
			), $categories
		);
		$this->view->categories = $categories;
	}
	
	public function paramAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo json_encode($this->_request->getParams());
	}
	
	public function indexAction()
	{
		require_once "toanvq.php";
		
		$this->_helper->layout->disableLayout();
		
		
		$this->view->selected_stg_id = 12;
	}
	
	public function testAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo preg_replace('/<img/', '<img style="width:100%;" /', '<img src="http://www.knorr.com.vn/Images/1056/1056-689526-11.png" width="60" alt="Kim châm, bông bí nấu giò sống">');
	}
	
	public function test2Action()
	{
		$this->_helper->viewRenderer->setNoRender();
		$arr = array("a","b","c","d");
		
		foreach ($arr as $value) {
			echo $value;
			if ($value == "b") {
				break;
			}
		}
	}
	
	public function test3Action()
	{
		$this->_helper->viewRenderer->setNoRender();
		print_r(explode("/", "https://www.youtube.com/channel/UCGnjeahCJW1AF34HBmQTJ-Q"));
	
	}
	
	public function imgresizeAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		// Zend_Loader::loadClass("simpleImage");
// 		
		// $image = new SimpleImage();
	   	// $image->load('./assets/upload/14147279655453091dc64f4.png');
	   	// $image->resizeToHeight(60);
	   	// $image->save('./assets/picture2.png');
		
		include_once "toanvq.php";
		
		echo imgResize('/assets/upload/14147279655453091dc64f4.png', -1, 60);
	}
	
	public function testresizeAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		// $imagik = new Imagick('assets/upload/141397111554477cab169e6.png');
		phpinfo();
		// if (!extension_loaded('imagick'))
    		// echo 'imagick not installed';		
	}
	
	public function getimgAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$url = 'http://www.youtube.com/yt/brand/media/image/YouTube-icon-full_color.png';
		// $file = file_get_contents($url);
// 		
		// echo finfo_file($file);
// 		
		// $img = './assets/test.jpg';
		// file_put_contents($img, $file);
		// print_r(getimagesize($img));
		include_once 'toanvq.php';
		echo getFile($url);
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
	
	function checkhttp($url) {
		$pos = strpos ($url ,"http" );
	    if ($pos === false || $pos !== 0 ) {
	        return false;
	    }
	    return true;
	}
	
	function changeImageUrl($url,$source_code = 0){
		switch ($source_code) {
//			Vietnamnet
			case 1:
		    	$url = preg_replace("/\?w=100&h=75?/","",$url);
		    	$url = preg_replace("/\?w=102&h=78?/","",$url);
		    	$url = preg_replace("/\?w=130&h=98?/","",$url);
		    	$url = preg_replace("/\?w=130&h=100?/","",$url);
		    	$url = preg_replace("/\?w=150&h=113?/","",$url);
				$url = preg_replace("/-102x77./",".",$url);
				$url = preg_replace("/-150x113./",".",$url);
				break;
//				Vnexpress
			case 2:
				$url = preg_replace("/_m_180x108/","",$url);
				$url = preg_replace("/_m_122x122/","",$url);
				$url = preg_replace("/_m_300x180/","",$url);
				$url = preg_replace("/_m_490x294/","",$url);
				break;
//				Báo mới
			case 3:
				$url = preg_replace("/\/zoom\/130_100/","",$url);
				$url = preg_replace("/\/thumb_w\/200/","",$url);
				break;
//				Soha
			case 4:
				$url = preg_replace("/\/zoom\/100_100/","",$url);
				$url = preg_replace("/\/zoom\/320_200/","",$url);
				$url = preg_replace("/\/zoom\/640_400/","",$url);
				break;
//				GenK
			case 5:
				$url = preg_replace("/\/zoom\/80_62/","",$url);
				$url = preg_replace("/\/zoom\/320_200/","",$url);
				break;
//				Dân trí
			case 7:
				$url = preg_replace("/\/zoom\/130_100/","",$url);
				$url = preg_replace("/\/zoom\/260_200/","",$url);
				break;
//				Seatimes
			case 8:
				$url = preg_replace("/\/resize_162x94/","",$url);
				$url = preg_replace("/\/resize_168x92/","",$url);
				$url = preg_replace("/\/resize_175x100/","",$url);
				$url = preg_replace("/\/resize_194x110/","",$url);
				$url = preg_replace("/\/resize_200x130/","",$url);
				$url = preg_replace("/\/resize_250x150/","",$url);
				$url = preg_replace("/\/resize_300x205/","",$url);
				$url = preg_replace("/\/resize_423x205/","",$url);
				$url = preg_replace("/\/resize_425x245/","",$url);
				$url = preg_replace("/\/resize_600x400/","",$url);
				break;
//				Một thế giới
			case 9:
				$url = preg_replace("/\?width=100&height=75&crop=auto/","",$url);
				break;
//				Lao động
			case 10:
				break;
//				Tiền phong
			case 11:
				$url = "http:" . $url;
				$url = preg_replace("/.ashx\?w=270&h=160&crop=auto/","",$url);
				$url = preg_replace("/.ashx\?w=608&h=302&crop=auto/","",$url);
				$url = preg_replace("/.ashx\?w=660&h=371&crop=auto/","",$url);
				$url = preg_replace("/\?w=270&h=160&crop=auto/","",$url);
				$url = preg_replace("/\?w=608&h=302&crop=auto/","",$url);
				$url = preg_replace("/\?w=660&h=371&crop=auto/","",$url);
				break;
//				Bongdaplus
			case 13:
				$url = preg_replace("/_t/","",$url);
				break;
//				Bongda.com.vn
			case 15:
				$url = preg_replace("/1.jpg?/",".jpg",$url);
				break;
//				Ngoi sao
			case 17:
				$url = preg_replace("/_v.80x0/","",$url);
				$url = preg_replace("/\/resize_80x80/","",$url);
				break;
//				Techz
			case 17:
				$url = preg_replace("/\/resize_x210x130/","",$url);
				$url = preg_replace("/\/resize_x320x240/","",$url);
				break;
//				ictnews
			case 19:
				$url = preg_replace("/_200x150/","",$url);
				break;
//				Cafef
			case 20:
				$url = preg_replace("/\/thumb_w\/320/","",$url);
				break;
//				Vneconomy
			case 21:
				$url = preg_replace("/\/zoom\/120_78/","",$url);
				break;
//				Danviet.vn
			case 22:
				$url = preg_replace("/\/ThumbImages/","",$url);
				$url = preg_replace("/_70./",".",$url);
				break;
//				Báo pháp luật tp.Hồ Chí Minh		
			case 24:
				$url = preg_replace("/\?width=300&height=225&crop=auto/","",$url);
				break;
//				Gamelandvn
			case 26:
				$url = preg_replace("/-144x144/","",$url);
				$url = preg_replace("/144x144/","",$url);
				break;
			default:
				;
			break;
		}
		return $url;
	}
	
	public function importallAction()
	{
		echo "News Getter<br/>";
		Zend_Loader::loadFile(APPLICATION_PATH."/..\library\simple_html_dom.php");
		
		$link_get_content_model = new Model_LinkGetContent;
		$news_model = new Model_News;
		
		$link_get_contents = $link_get_content_model->getAll();
		
		$count = 0;
		foreach ($link_get_contents as $link_get_content) {
			// $client = new Zend_Http_Client("http://www.knorr.com.vn/recipes/canh/297426");
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
				$html = str_get_html($html_text);
				
				$nodes = $html->find($link_get_content['news_list_xpath']);
				foreach ($nodes as $node) {
					// echo $link_get_content['id']."<br/>";
					
					$data = array();
					$data['source_id'] = $link_get_content['source_id'];
					$data['sub_category_id'] = $link_get_content['sub_category_id'];
					
					$title = $node->text();
					$title = @mb_convert_encoding($title, 'html-entities', mb_detect_encoding($title));
					
					//GET TITLE
					$data['title'] = $title;
					
					//GET LINK
					$data['url'] = $node->getAttribute('href');
					if (!$data['url']) {
						$data['url'] = $node->parent()->getAttribute('href');
					}
					if (!$this->checkhttp($data['url'])){
						$data['url'] = $link_get_content['home_page'] . $data['url'];
					}
					
					//GET COVER
					$node_parent = $node->parent();
					do {
						$img_node = $node_parent->find('img',$link_get_content['icon_position']);
						$node_parent = $node_parent->parent();
					}while (!$img_node);
					$data['icon'] = $img = $this->changeImageUrl($img_node->getAttribute("src"),$link_get_content['source_id']);
					
					//GET NODE TITLE FINISH
					//GET NODE CONTENT START
					$validator = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news",
																			'field' => 'url'
					));
					$validator_error_link = new Zend_Validate_Db_NoRecordExists(array("table"	=> "news_error",
																						'field' => 'url'
					));
					if ($validator_error_link->isValid($data['url'])){
						if ($data['url'] && $data['title'] && $data['icon'] && $validator->isValid($data['url'])){
							$news_detail_client = new Zend_Http_Client($data['url']);
							$news_detail_client->setConfig(array(
						        // "useragent"		=> "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16", 
						        "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36", 
						        "timeout"		=> 10, 
						        "maxredirects" => 1
							));
							try {
								$news_body = $news_detail_client->request("GET")->getBody();
								$news_text = @mb_convert_encoding($news_body, 'utf-8', mb_detect_encoding($news_body));
								$news_text = @mb_convert_encoding($news_text, 'html-entities', 'utf-8');
								$news_text = @mb_convert_encoding($news_text, 'utf-8','html-entities');
			
								$news = str_get_html($news_text);
								
								// if ($link_get_content['title_from_content']){
									// $title_node = $news->find($link_get_content['title_xpath'],0);
									// if ($title_node){
										// $data['title'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($title_node->text()));
									// }
								// }
								
								$data['description'] = "";
								// $data['description'] = $link_get_content['description_xpath'];
								// $description_node = $news->find(".content",3);
								// if ($description_node){
									// // foreach($description_node->find("div") as $element){
					   					// // $element->clear();
									// // }
									// // $data['description'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($description_node->text()));
									// $data['description'] = $description_node->text();
									// $data['description'] = @mb_convert_encoding($data['description'], 'html-entities', mb_detect_encoding($data['description']));
								// }
								
								
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
								$content_node = $news->find($link_get_content['content_xpath']);
								$data['content'] = "";
								foreach ($content_node as $content_mini_node) {
									$data['content'].= ($this->removeDoubleSpace($content_mini_node->innertext()));
									// foreach ($content_node->find("p > span > span") as $mininode) {
										// $data['content'].= $mininode->text();
									// }
									// $data['content'] = $content = ($this->removeDoubleSpace($content_node->innertext()));
									$data['content'] = @mb_convert_encoding($data['content'], 'html-entities', mb_detect_encoding($data['content']));
								}
								try {
									if ($data['content']){
										$news_model->insert($data);
										$count++;
									}else{
										// $news_error_model->insert(array("url"	=> $data['url']));
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
						
						// $news_model->insert($data);
					}
					echo "<pre>";
					print_r($data);
					echo "</pre>";
					
					// echo $node->text()."<br/>";
					// echo $node->getAttribute("href")."<br/>";
					// echo $node->parent()->parent()->getElementByTagName("div.t-top-sum")."<br/><br/><hr/>";
					// break;
					// print_r($value);
					
					// echo "<hr/>";
				}
			}catch(exception $e){
				echo "<br/>Error:<br/>".$e;
			}
		}
		echo "$count article imported";
	}


}