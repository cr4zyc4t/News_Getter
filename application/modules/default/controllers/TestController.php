<?php

class TestController extends Zend_Controller_Action
{
	public function strposAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		if(strpos("/Uploaded/anhtu/2015_04_15/putin_clinton_AXGP.jpg","/Uploaded") === 0){
			echo "string";
		};
		echo buildURL("http://motthe.vn","/Uploaded/anhtu/2015_04_15/putin_clinton_AXGP.jpg");
	}
	
	public function newscriptAction()
	{
		
	}
	
	public function gmapAction()
	{
		$this->_helper->layout->disableLayout();
	}
	
	public function init()
	{
		$option=array(
	        "layout" => "basic",
	        "layoutPath" => APPLICATION_PATH."/layouts/scripts/"
      	);
      	Zend_Layout::startMvc($option);
        $this->view->headTitle("QHOnline - Zend Layout");
		
		require_once "toanvq.php";
	}
	
	public function remoteAction()
	{
		$cmd = $this->_request->getParam('cmd');
		if ($this->_request->isPost() && $cmd) {
			$this->view->cmd = $cmd;
			$out = shell_exec($cmd);
			$this->view->result = $out;
		}
	}
	
	public function execAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		// echo $cmd = "java -jar '/var/www/html/convert_wav_to_mp3/convert.jar' ".PUBLIC_PATH."/audio/2015-02-27/wav/19483.wav"." ".PUBLIC_PATH."/assets/audio/test2.mp3";
		// echo $cmd = "java -jar '/var/www/html/convert_wav_to_mp3/convert.jar' ".PUBLIC_PATH."/audio/2015-02-27/wav/19483.wav"." ".PUBLIC_PATH."/audio/2015-02-27/wav/1943.mp3";
		
		$cmd = "ps aux|grep java";
		echo $cmd;
		$out = shell_exec($cmd);
		
		echo "<br/>".nl2br($out);
	}
	
	public function getterAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		echo $cmd = "nohup java -jar ".PUBLIC_PATH."/jar/autoget_stable_20150312.jar &";
		// echo $cmd = "java -jar '/var/www/html/convert_wav_to_mp3/convert.jar' ".PUBLIC_PATH."/audio/2015-02-27/wav/19483.wav"." ".PUBLIC_PATH."/audio/2015-02-27/wav/19483.mp3";
		$out = shell_exec($cmd);
		
		echo "<br/>".$out;
	}
	
	public function export2excelAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$dbParams = array(
			"host" => "localhost",
			"username" => "root",
			"password" => "",
			"dbname" => "widget_publisher",
			"charset" => "utf8"
		);
		$db = Zend_Db::factory("Pdo_mysql", $dbParams);
		$db->setFetchMode(Zend_Db::FETCH_ASSOC);

		$sql = $db->select()->from("widget_publisher_code", array("sum(clicks) as sum_clicks","city","net"))->group('city')->group('net');

		$result = $db->fetchAll($sql);
		$total = $db->fetchAll("SELECT SUM(clicks) as sum_clicks, net FROM widget_publisher_code GROUP BY net");
		$total_report = array();
		foreach ($total as $key => $value) {
			$total_report[$value['net']] = $value['sum_clicks'];
		}
		// arr_dump($total_report);die;
		
		$data = array();
		
		foreach ($result as $key => $value) {
			if (!isset($data[$value['city']])) {
				$data[$value['city']] = array($value['city'], 0, 0, 0, 0,0);
			}
			// echo $data[$value['city']][$value['net']];
			// echo "<br/>".$value['sum_clicks'];
			// echo "<br/>".$total_report[$value['net']]; die;
			$data[$value['city']][$value['net']]+= 100 * $value['sum_clicks'] / $total_report[$value['net']];
		}
		// arr_dump($data);
		foreach ($data as $province => $province_data) {
			$data[$province][1] = round($province_data[1],2)."%";
			$data[$province][2] = round($province_data[2],2)."%";
			$data[$province][3] = round($province_data[3],2)."%";
			$data[$province][4] = round($province_data[4],2)."%";
			$data[$province][5] = round($province_data[5],2)."%";
		}
		
		$inputFileName = "./assets/excel/template.xls";
		/** Load $inputFileName to a PHPExcel Object  **/
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		
		//Sheet 1
		$objPHPExcel->setActiveSheetIndex(0);
		// $objPHPExcel->getActiveSheet()->setCellValue("A5", " HuiDeFa Reports");
		$objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A4');
		
		//Excel 2003
		$output_filename = "report.xls";
		header('Content-Type: application/vnd.ms-excel'); //mime type
        header("Content-Disposition: attachment;filename=\"$output_filename\""); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		
	}
	
	public function getbydateAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$model = new Model_Contents;
		$db = $model->getDefaultAdapter();
		$result = $db->fetchAll("SELECT * FROM news WHERE DATE(created_time) = '2014-12-27' ");
		arr_dump($model->getNoAudioNews());
	}
	
	public function ttsAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
		
		$text = 'Khi chọn mặt gởi vàng tại hệ thống bán lẻ đã được ủy quyền trở thành đại lý chính thức của những nhãn hàng nổi tiếng như: Apple, Asus, Oppo bạn sẽ được nhận những sản phẩm tốt nhất, giá cả phù hợp cũng như được hưởng đầy đủ những chương trình khuyến mãi hấp dẫn kèm theo. Ngoài ra, chế độ bảo hành, hay những chương trình chăm sóc hậu mãi cũng là những yếu tố đầy hấp dẫn của hàng chính hãng dành cho các bạn.';
		
		$content_id = $this->_request->getParam('id');
		if (!$content_id) {
			$content_id = 2555;
		}
		
		$model_news = new Model_Contents;
		$news = $model_news->getById($content_id);
		
		$text = html_entity_decode(strip_tags($news['content']));
		
		// $text = "Hello world";
		if ($this->_request->getParam('test')) {
			$text = "Khi chọn mặt gởi vàng tại hệ thống bán lẻ đã được ủy quyền ";
		}
		
		echo $text;
		
		echo "<br/>".getAudioFile($text);
	}
	
	public function cleanfolderAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$dir = "./assets/audio/2015-02-27/";
		rmdir("./assets/audio/2014-02-26/wav");
		rmdir("./assets/audio/2014-02-26");
		foreach (scandir($dir) as $key => $value) {
			if (($value != ".") && ($value != "..")) {
				foreach (scandir($dir.$value) as $wav) {
					if (getFileExtension($wav) == "wav") {
						unlink($dir.$value.DIRECTORY_SEPARATOR.$wav);
					}
				}
			}
		}
	}
	
	public function filesAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$dir = "./assets/sound/";
		
		foreach (scandir($dir) as $key => $value) {
			if (($value != ".") && ($value != "..")) {
				foreach (scandir($dir.$value) as $wav) {
					echo "http://content.amobi.vn/assets/sound/".$value."/".$wav."<br/>";
				}
			}
		}
	}
	
	public function testfileAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$file = "./assets/sound/2015-02-26/54ee95cec8d28.wav";
		// arr_dump(pathinfo($file));
		$file_info = new finfo(FILEINFO_MIME_TYPE);
		$mime_type = $file_info->buffer(file_get_contents($image_url));
		echo $mime_type;
	}
	
	public function listsubctgAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$model = new Model_Subcategory;
		arr_dump($model->getListSubCtg(133));
	}
	
	public function gdataAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		
		$username = 'hunterxbn'; 
	    $youtube  = new Zend_Gdata_YouTube(); 
	    try { 
	         $feed = $youtube->getUserUploads($username); 
	    } 
	    catch (Exception $ex) { 
	         echo $ex->getMessage(); 
	         exit; 
	    }
		arr_dump($feed);
	}
	
	public function linksttAction()
	{
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		$link_model = new Model_LinkGetContentLegacy;
		$link_model->markAsFinish(100);
		echo "success";
	}
	
	public function listcategoryAction()
	{
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		
		$model_category = new Model_Category;
		
		arr_dump($model_category->getListCategory(1,1000));
	}
	
	public function listcontentAction()
	{
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		
		$model_category = new Model_Contents;
		
		arr_dump($model_category->getByCategory(121,18,0));
	}
	
	public function parseintAction()
	{
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		echo intval("Tập 320 - Tinh giảm biên chế ");
		$str = '"Tập  - Tinh giảm biên chế "';
		preg_match('!\d+!', $str, $matches);
		print_r($matches);
	}
	
	public function chartdataAction()
	{
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		// Set the JSON header
		header("Content-type: text/json");
		
		// The x value is the current JavaScript time, which is the Unix time multiplied 
		// by 1000.
		$x = time() * 1000;
		// The y value is a random number
		$y = rand(0, 100);
		
		// Create a PHP array and echo it as JSON
		$ret = array($x, $y);
		echo json_encode($ret);
	}
	
	public function strreplaceAction()
	{
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		echo str_replace("5S Online",'',"5S Online - aqwfwfawef - 5S Online aswefewfewfaswefew");
	}
	
	public function highchartAction()
	{
		
	}
	
    public function authinfoAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance();

        arr_dump($auth->getIdentity());
    }

	public function db2Action(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$dbParams = array(
			"host" => "localhost",
			"username" => "content.amobi.vn",
			"password" => "nxB8xSeKg99n",
			"dbname" => "news_getter",
			"charset" => "utf8"
		);
		$db = Zend_Db::factory("Pdo_mysql", $dbParams);
		$db->setFetchMode(Zend_Db::FETCH_ASSOC);

		$sql = $db->select()->from("category");

		arr_dump($db->fetchRow($sql));


		$dbParams = array(
			"host" => "hay.qplay.vn",
			"username" => "hayqplayvn_new",
			"password" => "ESU05JjLxeGw3AHE",
			"dbname" => "hayqplayvn_new",
			"charset" => "utf8"
		);
		$db = Zend_Db::factory("Pdo_mysql", $dbParams);
		$db->setFetchMode(Zend_Db::FETCH_ASSOC);

		$query = $db->select()->from("category");

		arr_dump($db->fetchAll($query));
	}

    public function browserAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $url = "http://huyenbi.net/tu_vi_nam_sinh";

        $client = new Zend_Http_Client($url);
        $client->setConfig(array(
            "useragent"		=> "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36",
            "timeout"		=> 10,
            "maxredirects"	=> 1
        ));
        echo $body = $client->request("GET")->getBody();
    }

	public function html5playerAction(){
//		$this->view->streamUrl = "rtmp://127.0.0.1:1935/oflaDemo/hobbit_vp6.flv";
	}

	public function flashplayerAction(){
		$this->view->streamUrl = "rtmp://example.com/application/mp4:myVideo.mp4";
	}

    public function testhelperAction(){
        $this->_helper->viewRenderer->setNoRender();

        $helper = new Vqt_System_Helper();
//        echo $helper->testhelper("aefaefe");
    }
	
	public function getparamsAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$get_params = $this->_request->getQuery();

		$module = $this->_request->getModuleName();
		$controller = $this->_request->getControllerName();
		$action = $this->_request->getActionName();

		$request = "/$module/$controller/$action?".http_build_query($get_params);
		// foreach ($get_params as $key => $value) {
			// $request.="&$key=$value";
		// }
		// echo $request;
		
		echo Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
	}
	
	public function ckeditorAction()
	{
		$this->_helper->layout->setLayout('admin');
		
	}
	
	public function admintestAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$auth = Zend_Auth::getInstance();
		arr_dump($auth->getIdentity());
	}
	
	public function datatableAction()
	{
		$this->_helper->layout->setLayout('admin');
		
		include_once 'toanvq.php';
		$subcategory_id = 34;
		if ($subcategory_id) {
			$subcategory = new Model_Subcategory;
			$subcategory = $subcategory->detail($subcategory_id);
			
			$category = new Model_Category;
			$category = $category->detail($subcategory['category_id']);
			
			$bigtype = new Model_Bigtype();
			$bigtype = $bigtype->getById($category['type_id']);
			
			$this->view->navibar = navibar(3,$category['type_id']);
			$this->view->pageHeader = "<a href=\"/admin/manage/subcategory?category_id=$category[id]\">$category[title]</a>";
			$this->view->pageSubtitle = "<a href=\"/admin/manage/listcontent?subcategory_id=$subcategory[id]\">$subcategory[title]</a>";
			
			$contents = new Model_News;
			$this->view->tableData = $contents->tableData($subcategory_id);
			$this->view->subcategory_id = $subcategory_id;
		}
	}
	
	public function paramAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo json_encode($this->_request->getParams());
	}
	
	public function indexAction()
	{
		if ($this->_request->getParam("view")) {
			$this->_helper->layout()->disableLayout();
		}
			$this->_helper->viewRenderer->setNoRender();
			arr_dump($this->_request->getParams());
		
		
	}
	
	public function blankAction()
	{
		echo TRUE;
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

    public function policyAction(){
        $this->_helper->viewRenderer->setNoRender();

        echo "Test policy";
    }
	
	public function fbinitAction()
	{
//		$this->_helper->viewRenderer->setNoRender();
		require_once "facebook-php-sdk-3/src/facebook.php";

        $config = array(
            'appId' => '808852962491530',
            'secret' => '507b608f4a33c83d7314d2d190f1920d',
            'cookie' => true,
            'fileUpload' => false, // optional
            'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
        );

        $facebook = new Facebook($config);

        $user = $facebook->getUser();
        if($user){
            try{
                $user_profile = $facebook->api("/me");

                arr_dump($user_profile);
            }catch (FacebookApiException $e){
                arr_dump($e);
            }
        }else{
            $loginUrl = $facebook->getLoginUrl(array(
                'scope'	=> 'email', // Permissions to request from the user
            ));

            $this->view->fbLoginUrl = $loginUrl;
        }



        arr_dump($this->_request->getParams());
	}
	
	public function fbtestAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		require_once "facebook-php-sdk-3/src/facebook.php";

        $config = array(
            'appId' => '808852962491530',
            'secret' => '507b608f4a33c83d7314d2d190f1920d',
            // 'cookie' => true,
            // 'fileUpload' => false, // optional
            // 'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
        );

        $facebook = new Facebook($config);
		
		try{
			$data = $facebook->api("/me",array(
	        	"access_token" => $this->_request->getParam("token")?$this->_request->getParam("token"):"CAALfpcGBPIoBAErnakZC4pFJAFskoccVvFKwFJ72KiKcZA1OLbtJZAEUWZCbPAVhw6HL0vcrO5qwxS2Lq7SbbgVrpFGGnCP8Ds3ZADZAtl3gc3qCJGcTRJyWa0E9QEeZA2ALov8l1XiVB1vUvoHTsMuJ5vaZCS6owvVKISUt3Cgb3h23TVEBIAhhXGeiMUJm84NMSHN0fZC70YUdGlaYIYxYJ"
	        ));
		}catch(FacebookApiException $error){
			arr_dump($error->getMessage());
		}
        
		arr_dump($data);
		
		echo "<img src=\"https://graph.facebook.com/100001337796176/picture?type=large\" />";
	}

    public function fblogincallbackAction()
    {
		$this->_helper->viewRenderer->setNoRender();
        echo "callback";
        arr_dump($this->_request->getParams());
    }
	
	public function phpinfoAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		phpinfo();
	}
	
	public function phpinfo2Action()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo PHP_INT_SIZE;
	}

	public function timestampAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		echo time();
	}

    public function mongogroupAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $mongo = new MongoClient();

        $db = $mongo->cms;

        $collection = $db->tracking;

//        $g = $collection->group(array("IP" => 1), array("items"=>array()), "function (obj, prev) { prev.items.push(obj.Timestamp); }");
//
//        $temp = $g['retval'];
//        echo $g['keys'];
//        arr_dump($temp);
		$date_report = date("Y-m-d");
		if(isset($_GET['date'])){
			echo $date_report = $_GET['date'];
		}
		$date_stamp = strtotime($date_report);
        $g = $collection->aggregate(
            array('$match'=> array(
                                "Timestamp"=> array(
                                                '$gte'=> $date_stamp,
                                                '$lte' => $date_stamp + 86400,
                                            )
                                )
                            ),
            array('$group' => array(
                "_id" => array("tags" => '$IP')
                )
            )
        );
        $temp = $g;
        echo "<br/>".count($g['result']);
        arr_dump($temp);

//        $cursor = $collection->find();
//        echo $cursor->count()."<br/>";
//        // iterate cursor to display title of documents
//        foreach ($cursor as $document) {
//            echo @$document["IP"] . "<br/>";
//        }
    }
	
	public function mtestmongoAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$mongodb = new Model_Mongotest;
		$mongodb->insert(array("name" => "toanvq", "age" => 25));
		// arr_dump($mongodb->fetchAll());
		
		$mongodb->remove(array("age" => 24));
		
		foreach ($mongodb->fetchAll() as $key => $value) {
			// echo $key."<br/>";
			arr_dump($value['_id']->{'$id'});
			
			// echo $value['name'];
			// var_dump($value);
			// echo $value['asrgdsrg'];
		}
		
 		// $m = new MongoClient();
		// echo "Connection to database successfully";
		// // select a database
		// $db = $m -> cms;
		// echo "Database mydb selected";
		// $collection = $db -> tracking;
		// echo "Collection selected succsessfully";
		// $document = array("title" => "MongoDB", "description" => "database", "likes" => 100, "url" => "http://www.tutorialspoint.com/mongodb/", "by", "tutorials point");
		// $collection -> insert($document);
		// echo "Document inserted successfully";
// 
		// $cursor = $collection -> find();
		// // iterate cursor to display title of documents
		// foreach ($cursor as $document) {
			// arr_dump($document);
		// }
	}

	public function requestinfoAction()
	{
		
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		arr_dump(getallheaders());
		arr_dump($_POST);
	}
	
	public function erasetrackdataAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		$tracking_model = Model_Tracking::remove(array());
	}
	
	public function trackinginfoAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		foreach (Model_Tracking::fetchAll( array('Request-Params.controller' => 'ytservice') ) as $track) {
			arr_dump($track);
		}
	}
	
	public function baseurlAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		
		echo Zend_Controller_Front::getInstance()->getBaseUrl();
	}
	
	public function parseurlAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$url = "/Uploaded/anhtu/2015_02_06/nhat-ban_LGKF.jpg";
		arr_dump(parse_url(''));
		
		var_dump(checkhttp($url));
		
		echo buildURL("http://m.motthegioi.vn/quoc-te/thi-su-quoc-te/", $url);
	}
}

