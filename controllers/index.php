<?php //allahoma sale ala mohammad va ale mohammad
//index page for view in general. on view layer start 6-2-91 by nasser niazy in 

class index
{
	public function __construct()
	{
		//constructor
		if (! isset(GSMS::$class['template']))
			GSMS::load('template','core');
		GSMS::$class['system_log']->log('DEBUG', 'index controller started successfull');
	}//fun
		
	public function logout()
	{
		GSMS::$class['session']->logout();
		GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
	}	
	
	public function index($begin=0, $end=30)
	{
		$begin=($begin < 0  ? 0 : $begin) ; 
		$end=($end < 1  ? 30 : $end) ; 
	
		if (GSMS::$class['session']->checkLogin()==true)
		{
			$user=GSMS::$class['session']->getUser();
			
			if($user['UserType'] == 1)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/admin/index");
				return;
			}
			elseif($user['UserType'] == 2)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/index");
				return;
			}
			elseif($user['UserType'] == 3)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/super/index");
				return;
			}
			
		}
		
		$this->home() ; 
		
		
	}
	
	
	public function coverGroupView($id=0,$type=1)
	{
		
		GSMS::load('template','core');
		
		$photo =R::dispense('picture');
		$photo = R::load('picture',$id);
			
		$path='';
		
		if($photo == 404 ||$id== 0)
		{
			switch($type)
			{ 
				case 1: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupCover.jpg";break;
				case 2: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telidCover.jpg";break;
				case 9: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/adsCover.jpg";break;
			}
		}
		else
		{
			$path=GSMS::$config['photo_archive_path'].$photo->picture_path;
		}
		
		 return $this->loadImage($path);
	}
	
	public function iconGroupView($id=0,$type=1)
	{
		GSMS::load('template','core');
		GSMS::load('picture','models');
		
		$photo =R::dispense('picture');
		$photo = R::load('picture',$id);
		
		$path='';
		
		if($photo == 404 ||$id== 0)
		{
			switch($type)
			{
				case 1: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupIcon.png";break;
				case 2: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telidIcon.png";break;
				case 3: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telstickerIcon.png";break;
				case 4: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telrobotIcon.png";break;
				case 7: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telchannelIcon.png";break;
				case 9: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/adsIcon.png";break;
				default: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupIcon.png";break;
			}
		}
		else
		{
			$path=GSMS::$config['photo_archive_path'].$photo->picture_path;
		}
		
		if($type ==11 )
			return $this->loadImage($path,false);
		else  
			return $this->loadImage($path,($id!=6767));
		
		
	}
	
	private function loadImage($path,$mini =false)
	{
		
		//ini_set('display_errors', 'off'); 
		// Report simple running errors 
		//error_reporting(E_ALL );
	   // File Exists? 
	   if( file_exists($path) )
	    {
			
			//$im = imagecreatefrompng($path);
			$im=null;
			$gis        = getimagesize($path );
			$type        = $gis[2];
			header("Cache-Control: private, max-age=10800, pre-check=10800");
			header("Pragma: private");
			header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
			switch($type)
			{
				 case "1": 
					header('Content-type: image/gif');
					$im = imagecreatefromgif($path); 
					break;
				 case "2": 
					header('Content-type: image/jpeg');
					$im = imagecreatefromjpeg($path);
					break;
				 case "3": 
					
					header('Content-type: image/png');
					$im = imagecreatefrompng($path); 
					imagealphablending($im, true);
					
					break;
				 default: continue ;
			}
			if($mini == true)
			{
				$new_width=GSMS::$config['photo_small_width'];
				$new_height=GSMS::$config['photo_small_height'];
				
				$width = imagesx($im); 
				$height = imagesy($im);
				
				$thumb = imagecreatetruecolor($new_width, $new_height);
				imagealphablending($thumb, true);
				imagesavealpha($im, true);
				
				//$new_image = imagecreatetruecolor($new_width,$new_height); 
				
				
				//ImageCopyResized($new_image, $im,0,0,0,0, $new_width, $new_height, $width, $height);
				imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagepng($thumb );
				
				header("Content-Disposition: inline; filename=".basename($path));
				imagedestroy($new_image);
				imagedestroy($im);
				return;
			}
		
			header("Content-Disposition: inline; filename=".basename($path));
			imagepng($im );
			imagedestroy($im);

		} else 
			die('File Not Found:'.$path);
	}
	
	
	function help()
    {
		$inf = array('page_title' => 'راهنمای استفاده از سایت  تلگرام گرد ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'راهنمای استفاده از سایت تلگرام گرد');
        GSMS::$class['template']->load($inf,'site_header');
		
		$body='
		<div class="message-info">
		<h3> راهنمای استفاده از سایت تلگرام گرد  :</h3><br/>
برای ثبت گروه خود می توانید از نرم افزار موبایل تلگرام گرد استفاده کنید  که از همین صفحه قابل دانلود است . <br/>
برای مدیریت و ثبت گروه VIP  نیاز به ثبت نام دارید <br/>
برای جستجوی گروه مورد نظر خود می توانید از قسمت جستجو استفاده کنید .<br/>
</div>
	<br/>
	
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		
		';
        
		$inf = array('title' => 'راهنمای استفاده از سایت تلگرام گرد', 'body' => $body, 'dir' => 'rtl');
        GSMS::$class['template']->index($inf);
		$inf = array('title' => 'راهنمای استفاده از سایت تلگرام گرد', 'body' => '', 'dir' => 'ltr');
        GSMS::$class['template']->load($inf,'site_footer');
    }

	public function home()
	{
        $inf = array('page_title' =>  'فامیل اپ');
		
		GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf,'frontpage');
        //GSMS::$class['template']->load($inf,'site_footer');
	}
	
	public function rule()
	{
		GSMS::load('rule','site_view','frontpage');
	}
	public function about()
	{
		GSMS::load('about','site_view','frontpage');
	}
	public function question()
	{
		GSMS::load('question','site_view','frontpage');
	}
	
	public function contact($p='')
	{
		$p= (GSMS::$class['session']->checkLogin()==true) ? 1 : '' ;
		GSMS::load('contact','site_view','frontpage',$p);
		
	}
	public function requestVip()
	{
		
		GSMS::load('contact','site_view','frontpage',3);
		
	}
	 
	function app()
    {
		$inf = array('page_title' => 'دریافت اپ تلگرام گرد');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' =>  'دریافت اپ تلگرام گرد');
        GSMS::$class['template']->load($inf,'site_header');
		
		$body='<div class="message-info">
		 اگر شما صاحب یک کالا یا برند تجاری هستید می توانید گروه برند خود را در دسترس مشتریان خود قرار دهید .<br/>
		برای ثبت گروه خود می توانید از اپ موبایل تلگرام گرد استفاده کنید . <br/>
		همچنین می توانید با عضویت در سایت تلگرام گرد نیز گروه خود را ثبت کنید ، مدیریت کنید و همچنین گروه خود را ویژه کنید . <br/>
		برای تبدیل گروه خود به گروه ویژه پس از ثبت نام و ثبت گروه خود روی گزینه "ثبت گروه ویژه " در پنل کاربری خود کلیک کنید . <br/>
		با ثبت گروه خود به سایر هم وطنان و همشهریان خود اجازه می دهید گروه شما را پیدا کنند ،<br/>
		در آن عضو شوند،<br/>
		نظر بدهند ،<br/>
		رتبه بدهند ، <br/>
		محبوب کنند و ....<br/>
		
		
		<br/>
		
		<a class="btn btn-primary" href="'.GSMS::$class['template']->info['index'].'telgroups/app">دریافت اپ موبایل تلگرام گرد از بازار</a>
		<a class="btn btn-primary" href="'.GSMS::$class['template']->info['index'].'telgroups/app">دریافت اپ موبایل تلگرام گرد از گوگل</a>
		<a class="btn btn-primary" href="'.GSMS::$class['template']->info['index'].'telgroups/app">دانلود اپ موبایل تلگرام گرد  </a>
		</div>
		';
        
		$inf = array('title' =>  'دریافت اپ تلگرام گرد', 'body' => $body );
        GSMS::$class['template']->index($inf);
		$inf = array('title' =>  'دریافت اپ تلگرام گرد', 'body' => '' );
        GSMS::$class['template']->load($inf,'site_footer');
    }

}//class
?>