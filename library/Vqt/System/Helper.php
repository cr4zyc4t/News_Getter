<?php
class Vqt_System_Helper{
    public function arr_dump($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
	
	public function removeDoubleSpace($string){
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
	
	public function imgResize($file,$width = -1, $height = -1, $output = '')
	{
		Zend_Loader::loadClass("simpleImage");
		
		$image = new SimpleImage();
		
	   	$image->load(".$file");
		if (($width != -1) && ($height != -1)) {
			$image->resize($width, $height);
		}elseif ($width = -1) {
			$image->resizeToHeight($height);
		}elseif ($height = -1) {
			$image->resizeToWidth($width);
		}
		
		if ($output == '') {
			$output = "/assets/download/".uniqid(time(), TRUE).".".array_pop(explode(".", $file));
		}
	   	$image->save(".$output");
		return $output;
	}
	
	public function getFile($url, $save_path = "/assets/download/")
	{
		// $url = 'http://www.youtube.com/yt/brand/media/image/YouTube-icon-full_color.png';
		if ($save_path == "/assets/download/") {
			$save_path .= uniqid(time(), TRUE).".jpg";
		}
		
		$file_got = file_get_contents($url);
		if ($file_got) {
			if(file_put_contents(".$save_path", $file_got)){
				return $save_path;
			}
		}
		return FALSE;
	}
	
	public function getHtmlNode($url, $agent_mode = "desktop")
	{
		require_once 'default_simple_html_dom.php';
		
		$user_agents = array(
						'desktop' => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
						'mobile' => "Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53" 
						);
		$client = new Zend_Http_Client($url);
		$client->setConfig(array(
	        "useragent"		=> $user_agents[$agent_mode], 
	        "timeout"		=> 10, 
	        "maxredirects"	=> 1
		));
		$body = $client->request("GET")->getBody();
		$html_text = @mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
		$html_text = @mb_convert_encoding($html_text, 'html-entities', 'utf-8');
		$html_text = @mb_convert_encoding($html_text, 'utf-8','html-entities');
		
		return str_get_html($html_text);
	}
	
	public function getParamFromUrl($url, $param)
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
	
	public function httpRequest($url, $useragent = 'desktop', $timeout = 10, $max_redirect = 1)
	{
		$useragents = array(
			'desktop' => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
			'mobile' => "Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53" 
		);
		$client = new Zend_Http_Client($url);
			$config = array(
		        "useragent"		=> $useragents[$useragent], 
		        "timeout"		=> $timeout, 
		        "maxredirects"	=> $max_redirect
			);
		$client->setConfig($config);
		
		return $body = $client->request("GET")->getBody();
	}
}
