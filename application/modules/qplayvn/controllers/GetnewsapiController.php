<?php
class Qplayvn_GetnewsapiController extends Zend_Controller_Action
{
    //Mang tham so nhan duoc o moi Action
    protected $_arrParam;
	protected $_limitget = 7;
	
    public function init ()
    {
        $this->_arrParam = $this->_request->getParams();
        $this->view->arrParam = $this->_arrParam;

		include_once "toanvq.php";
    }
	
    public function preDispatch ()
    {
    	$this->_helper->viewRenderer->setNoRender();
//    	$this->_helper->layout()->disableLayout();
    }

	public function indexAction(){
		echo $url = "http://cache.media.techz.vn/upload/2015/02/06/image-1423208236-Quang canh.jpg";
		echo "<br/>";
		var_dump(checkhttp($url));
		echo buildURL("http://www.techz.vn/C/tin-tuc-cong-nghe", '');
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

	function changeImageUrl($url,$source_code = 0, $homepage = ''){
		switch ($source_code) {
//			Vietnamnet
			case 5:
		    	$url = preg_replace("/\?w=100&h=75?/","",$url);
		    	$url = preg_replace("/\?w=102&h=78?/","",$url);
		    	$url = preg_replace("/\?w=130&h=98?/","",$url);
		    	$url = preg_replace("/\?w=130&h=100?/","",$url);
		    	$url = preg_replace("/\?w=150&h=113?/","",$url);
				$url = preg_replace("/-102x77./",".",$url);
				$url = preg_replace("/-150x113./",".",$url);
				break;
//				Vnexpress
			case 6:
				$url = preg_replace("/_m_180x108/","",$url);
				$url = preg_replace("/_m_122x122/","",$url);
				$url = preg_replace("/_m_300x180/","",$url);
				$url = preg_replace("/_m_490x294/","",$url);
				break;
//				Báo mới
			case 7:
				$url = preg_replace("/\/zoom\/130_100/","",$url);
				$url = preg_replace("/\/thumb_w\/200/","",$url);
				break;
//				Soha
			case 8:
				$url = preg_replace("/\/zoom\/100_100/","",$url);
				$url = preg_replace("/\/zoom\/320_200/","",$url);
				$url = preg_replace("/\/zoom\/640_400/","",$url);
				break;
//				GenK
			case 9:
				$url = preg_replace("/\/zoom\/80_62/","",$url);
				$url = preg_replace("/\/zoom\/320_200/","",$url);
				break;
//				Dân trí
			case 10:
				$url = preg_replace("/\/zoom\/130_100/","",$url);
				$url = preg_replace("/\/zoom\/260_200/","",$url);
				$url = preg_replace("/\/zoom\/150_150/","",$url);
				break;
//				Seatimes
			case 11:
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
			case 12:
				$url_parts = split("\?", $url);
				$url = $url_parts[0];
				break;
//				Lao động
			case 13:
				break;
//				Tiền phong
			case 14:
				$url = "http:" . $url;
				$url = preg_replace("/.ashx\?w=270&h=160&crop=auto/","",$url);
				$url = preg_replace("/.ashx\?w=608&h=302&crop=auto/","",$url);
				$url = preg_replace("/.ashx\?w=660&h=371&crop=auto/","",$url);
				$url = preg_replace("/\?w=270&h=160&crop=auto/","",$url);
				$url = preg_replace("/\?w=608&h=302&crop=auto/","",$url);
				$url = preg_replace("/\?w=660&h=371&crop=auto/","",$url);
				break;
//				Bongdaplus
			case 16:
				$url = preg_replace("/_t/","",$url);
				break;
//				Bongda.com.vn
			case 18:
				$url = preg_replace("/1.jpg?/",".jpg",$url);
				break;
//				Ngoi sao
			case 20:
				$url = preg_replace("/_v.80x0/","",$url);
				$url = preg_replace("/\/resize_80x80/","",$url);
				$url = preg_replace("/\/resize_63x63/","",$url);
				break;
//				Techz
			case 21:
				$url = preg_replace("/\/resize_x210x130/","",$url);
				$url = preg_replace("/\/resize_x320x240/","",$url);
				break;
//				ictnews
			case 22:
				$url = preg_replace("/_200x150/","",$url);
				break;
//				Cafef
			case 23:
				$url = preg_replace("/\/zoom\/150_100/","",$url);
				break;
//				Vneconomy
			case 24:
				$url = preg_replace("/\/zoom\/120_78/","",$url);
				break;
//				Danviet.vn
			case 25:
				$url = preg_replace("/.ashx\?w=320&h=200&crop=auto/","",$url);
				break;
//				Báo pháp luật tp.Hồ Chí Minh
			case 27:
				$url = preg_replace("/\?width=300&height=225&crop=auto/","",$url);
				$url = "http://m.plo.vn".$url;
				break;
//				Gamelandvn
			case 29:
				$url = preg_replace("/-144x144/","",$url);
				$url = preg_replace("/144x144/","",$url);
				break;
			default:
				;
			break;
		}

		if (!checkhttp($url)) {
			// $url = $homepage.$url;
			$url = buildURL($homepage, $url);
		}
		return $url;
	}

	public function getnewsAction()
	{
		require_once 'default_simple_html_dom.php';
		
		$test = isset($_GET['test']);
		$limit = $this->_request->getParam("limit");
		if (!$limit) {
			$limit = $this->_limitget;
		}
		
		$reply = array();
		$reply['is_last'] = FALSE;
		$reply['error'] = null;
		$reply['count'] = 0;
		
		$link_get_content_model = new Model_LinkGetContentLegacy();
		
		$where = $link_get_content_model->getAdapter()->quoteInto("processed = ?",0);
		if ($link_id = $this->_request->getParam("link_id")) {
			$where = $link_get_content_model->getAdapter()->quoteInto("id = ?",$link_id);
		}
		$link_get_content_info = $link_get_content_model->fetchRow($where);
		
		$news_model = new Model_Contents();
		$news_error_model = new Model_NewsError();
		$count = 0;
		if ($link_get_content_info){
			$reply['link_info'] = $link_get_content_info = $link_get_content_info->toArray();
			try {
				if($html = getHtmlNode($link_get_content_info['url'], 'mobile')){
					$nodes = $html->find($link_get_content_info['news_list_xpath']);
					
					foreach ($nodes as $node){
						if ($test) {
							echo $node;
						}
						$data = array();

						$data['source_id'] = $link_get_content_info['source_id'];
						$data['type'] = 1;
						$data['subcategory_id'] = $link_get_content_info['sub_category_id'];

						$data['title'] = $title = $node->text();

						$node_parent = $node->parent();
						do {
							$img_node = $node_parent->find('img',$link_get_content_info['icon_position']);
							$node_parent = $node_parent->parent();
						} while (!$img_node);
						$data['icon'] = $img = $this->changeImageUrl($img_node->getAttribute("src"),$link_get_content_info['source_id'],$link_get_content_info['url']);

						$url = $node->getAttribute("href");
						if (!$url){
							$node_parent = $node;
							do {
								if ($node_parent->tag != "a"){
									$title_node = $node_parent->getElementByTagName('a');
								}else{
									$title_node = $node_parent;
								}
								$node_parent = $node_parent->parent();
							}while (!$title_node);

							$url = $title_node->getAttribute("href");
							if (!$data['title']){
								$data['title'] = $title = $title_node->text();
							}
						}

						$data['title'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($data['title']));

						if (checkhttp($url)){
							$data['url'] = $link = $url;
						}else{
							$data['url'] = $link = buildURL($link_get_content_info['url'],$url);
						}
						
						if ($link_get_content_info['source_id'] == 29) { //GamelandVN
							$description_node = $node_parent->find($link_get_content_info['description_xpath'],0);
							if ($description_node){
								foreach($description_node->find("a") as $element){
									$element->clear();
								}
								$data['description'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($description_node->text()));
							}
						}
						$validator = new Zend_Validate_Db_NoRecordExists(
							array(
								"table"	=> $news_model->_name,
								'field' => 'url'
							)
						);
						$validator_error_link = new Zend_Validate_Db_NoRecordExists(
							array(
								"table"	=> $news_error_model->_name,
								'field' => 'url'
							)
						);
						if ($validator_error_link->isValid($link) || $test){
							if ($validator->isValid($link) || $test) {
								if ($link && $title){
									try {
										$news = getHtmlNode($link, 'mobile');
										if(! is_object($news) ){
											continue;
										}
										
										if ($link_get_content_info['title_from_content']){
											$title_node = $news->find($link_get_content_info['title_xpath'],0);
											if ($title_node){
												$data['title'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($title_node->text()));
											}
										}
										
										$description_node = $news->find($link_get_content_info['description_xpath'],0);
										if ($description_node && !isset($data['description'])){
											foreach($description_node->find("a") as $element){
												$element->clear();
											}
											$data['description'] = preg_replace("/<[^>]*>/","",$this->removeDoubleSpace($description_node->text()));
										}
										$timesource_node = $news->find($link_get_content_info['time_xpath'],0);
										if ($timesource_node){
											if ($link_get_content_info['source_id'] == 27){
												$date = new Zend_Date();
											}else{
												$date = new Zend_Date($this->removeDoubleSpace($timesource_node->text()),$link_get_content_info['time_format']);
											}
											if (in_array($link_get_content_info['source_id'], array(26))){
												$date->setMinute(Zend_Date::now()->getMinute());
												$date->setHour(Zend_Date::now()->getHour());
												$date->setMilliSecond(Zend_Date::now()->getMilliSecond());
											}
											if($link_get_content_info['source_id'] == 25){
												$date->setYear(Zend_Date::now()->getYear());
											}
											$data['time'] = $date->toString('yyyy-MM-dd HH:mm:ss');
										}
										if ($link_get_content_info['tag_xpath']){
											$tag_node = null;
											if (!$link_get_content_info['tag_from_desktop_version']){
												$tag_node = $news->find($link_get_content_info['tag_xpath']);
											}else{
												if($tag_html = getHtmlNode(str_replace("http://m.", "http://", $link))){
													$tag_node = $tag_html->find($link_get_content_info['tag_xpath']);
												}
	
												if (($link_get_content_info['home_page'] == "http://m.ngoisao.vn/") || ($link_get_content_info['source_id'] == 25)){
													$timesource_node = $tag_html->find($link_get_content_info['time_xpath'],0);
													$date = new Zend_Date($this->removeDoubleSpace($timesource_node->text()),$link_get_content_info['time_format']);
													$data['time'] = $date->toString('yyyy-MM-dd HH:mm:ss');
												}
											}
											$tag_list = array();
											if ($tag_node){
												foreach ($tag_node as $tag){
													$tag_list[] = $this->removeDoubleSpace($tag->text());
												}
												$data['sys_tag'] = implode(",", $tag_list);
											}
										}
										
										if ($link_get_content_info['remove_tag_xpath']){
											$tag_list = explode("\r\n", $link_get_content_info['remove_tag_xpath']);
											$tag_list = array_reverse($tag_list);
											foreach ($tag_list as $tag) {
												$remove_tag = null;
												$remove_options = explode(":", $tag);
												if (count($remove_options) == 2) {
													$contain_remove_tag = $news->find($remove_options[0],0);
													if ($contain_remove_tag && $contain_remove_tag->last_child()) {
														$remove_tag = $contain_remove_tag->last_child();
														for ($i=0; $i < abs(intval($remove_options[1])); $i++) { 
															$remove_tag = $remove_tag->prev_sibling();
														}
													}
													
												}else{
													$remove_tag = $news->find($tag,0);
												}
												
												if ($remove_tag){
													$remove_tag->clear();
												}
											}
										}
										$content_node = $news->find($link_get_content_info['content_xpath'],0);
										
										if ($content_node){
											//FIX IMG SRC
											foreach ($content_node->getElementsByTagName("img") as $img_node) {
												$img_src = $img_node->getAttribute("src");
												if (!checkhttp($img_src)) {
													$img_node->setAttribute("src", buildURL($link_get_content_info['url'], $img_src));
												}
											}
											
											$data['content'] = $content = ($this->removeDoubleSpace($content_node->innertext()));
											
											// First image will be cover
											if (!$data['icon']) {
												$first_img_node = $content_node->getElementByTagName("img");
												if ($first_img_node) {
													$data['icon'] = $this->changeImageUrl($first_img_node->getAttribute("src"),-1 ,$link_get_content_info['url']);
												}
											}
										}
										try {
											if (isset($data['description']) && isset($data['time']) && isset($data['content'])){
												//FIX TIME
												if ((time() - strtotime($data['time'])) > 15552000) {
													$data['time'] = date("Y-m-d H:i:s");
												}
												//GET AUDIO FILE
												// if ($wav = getAudioFile(html_entity_decode(strip_tags($data['content'])))) {
													// $data['wav'] = $wav;
												// }
												
												if ($test) {
													arr_dump($data);
												}else{
													
													
													$news_model->insert($data);
												}
												
												$count++;
												$reply['count'] = $count;
												if($count == $limit){
													break;
												}
											}else{
												$news_error_model->insert(array("url" => $data['url']));
												$reply['error'] = "Missing required fields";
											}
										} catch (Exception $e) {
											$reply['error'] = "Loi luu trang";;
											echo json_encode($reply);
											die;
										}
									} catch (Exception $e) {
										$reply['error'] = "4|Loi khi load trang bao chi tiết";
										$news_error_model->insert(array("url" => $data['url']));
									}
								}else{
									$reply['error'] = "Missing basic fields";
									$news_error_model->insert(array("url"	=> $data['url']));
								}
							}
						}
						// break;
					}
					
					if ($count < $limit) {
						try {
							$link_get_content_model->markAsFinish($link_get_content_info['id']);
						} catch (Exception $e) {
							$reply['error'] = "4|DB Error - Link status change failed";
						}
					}
				}else{
					$reply['error'] = "9|Page not found ". $link_get_content_info['name'];
					$link_get_content_model->markAsError($link_get_content_info['id']);
				}
				$html->clear();
				unset($html);
			} catch (Exception $e) {
				$reply['error_info'] = $e;
				$reply['error'] = "2|Loi khi load trang bao";
			}
		}else{
			$reply['is_last'] = TRUE;
			echo "FINISH";
			die;
		}
		// if($reply['count'] == 0){
			// $where = $link_get_content_model->getAdapter()->quoteInto("id = ?",$link_get_content_info['id']);
			// $link_get_content_model->update(array("processed"	=> -1), $where);
		// }
		// if ($test) {
			// arr_dump($reply);
		// } else {
			// echo json_encode($reply);
		// }
		if ($link_get_content_info){
			echo "Got $count news from $link_get_content_info[id]| $link_get_content_info[name]";
		}
		
	}
	
	public function getaudioAction()
	{
		$id = $this->_request->getParam('id');
		
		$model_content = new Model_Contents;
		$news = null;
		$news = $model_content->getById($id);
		if (($news != null) && count($news)) {
			if ($news['wav']) {
				$this->view->src = $news['wav'];
			} else {
				$wav = getAudioFile(html_entity_decode(strip_tags($news['content'])), $news['id']);
				if ($wav) {
					$model_content->update(array("wav" => $wav), "id=$news[id]");
					$this->view->src = $wav;
				}
			}
		}else{
			echo "FINISH";
		}
	}
	
	public function getwavAction()
	{
		$model_content = new Model_Contents;
		$news = null;
		$news = $model_content->getNoAudioNews();
		arr_dump($news);
		if (isset($news['id'])) {
			if (!$news['wav']) {
				$words = html_entity_decode(strip_tags($news['content']));
				$wav = null;
				try{
					$wav = getAudioFile($words , $news['id']);
				}catch(Exception $error){
					arr_dump($error);
				}
				
				if ($wav) {
					$model_content->update(array("wav" => $wav), "id=$news[id]");
					echo $wav;
				}else{
					$model_content->update(array("wav" => FALSE), "id=$news[id]");
				}
			}
		}else{
			echo "FINISH";
		}
	}
	
	public function convert2mp3Action()
	{
		$model_content = new Model_Contents;
		$news = null;
		$news = $model_content->getNoMp3News();
		if (isset($news['wav'])) {
			if (!$news['mp3']) {
				$mp3_output_rel = "/assets/mp3/$news[id].mp3";
				$cmd = "java -jar '/var/www/html/convert_wav_to_mp3/convert.jar' ".APPLICATION_PATH."/..".$news['wav']." ".APPLICATION_PATH."/..".$mp3_output_rel;
				
				$out = shell_exec($cmd);
		
				echo "<br/>".$out;
			}
		}else{
			echo "FINISH";
		}
	}
	
	public function resetlinkAction(){
		$link_get_content = new Model_LinkGetContentLegacy();
		try {
			$link_get_content->update(array("processed"	=> 0),"processed > -1");
			echo "FINISH";
			die;
		} catch (Exception $e) {
			echo "2|Loi khi update db";
		}
	}
	
	public function testlinkAction()
	{
		$link_get_content_model = new Model_LinkGetContentLegacy();
		
		foreach ($link_get_content_model->fetchAll("processed=-1") as $link_get_content_info) {
			$news_model = new Model_Contents();
			$news_error_model = new Model_NewsError();
			
			$link_get_content_info = $link_get_content_info->toArray();
			try{
				$body = httpRequest($link_get_content_info['url'], 'mobile');
				if (!$body) {
					arr_dump($link_get_content_info);
				}
			}catch(Exception $e){
				arr_dump($e);
			}
		}
		
		// if ($link_get_content_info){
			// $reply['link_info'] = $link_get_content_info = $link_get_content_info->toArray();
			// try {
				// $body = httpRequest($link_get_content_info['url'], 'mobile');
				// $html_text = @mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
				// $html_text = @mb_convert_encoding($html_text, 'html-entities', 'utf-8');
				// $html_text = @mb_convert_encoding($html_text, 'utf-8','html-entities');
				// $html = str_get_html($html_text);
// 				
				// if($html){}
			// }catch(Exception $e){
				// print_r($e);
			// }
		// }
	}
}