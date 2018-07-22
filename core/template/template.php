<?php //allahoma sale ala mohammad va ale mohammad
//template used for display information with requested format. on model layer start 6-2-91 by nasser niazy in 
 $info = array();
class template
{
	public $info;
	//for fill info array by default value
	public function __construct()
	{
		global $info;
		$this->info =& $info;
		//for store all template configuration value
		$this->set_default_value();
		GSMS::$class['system_log']->log('debug', "template Class Initialized");
	}//func
	public function header($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'header.php');
	}//fun
		
	public function load($Info,$page)
	{
		$this->fetch_sent_info($Info);
		global $info;
		
		require_once($this->info['theme_path'].$page.'.php');
	}//fun
	
	public function paging($link,$begin,$itemCount)
	{
		$body='';
		if($itemCount > GSMS::$config['page_item_per_page'])
		{
			// paging code 
			
			$mx=round($itemCount / GSMS::$config['page_item_per_page']);
			
			if($begin<(GSMS::$config['page_item_per_page']*5))
			{
				$start =0;
			}
			else
			{
				 $start=( round($begin / GSMS::$config['page_item_per_page']) -5 ) ;
				 $body .='<a class="page_btn" href=\''.$link .'/0/'.GSMS::$config['page_item_per_page'].'\'>1</a>';
			}
			$forcount=0;
			
			
			for($i=$start ; $i<=$mx;$i++)
			{
				$forcount++;
				
				$body .=($i!=0 ?  '::':'');
				if(($i * GSMS::$config['page_item_per_page'])==$begin)
				{
					$body .= '<span class="page_btn_disabled">'.($i+1).'</span>' ;
					continue;
				}
				$body .='<a class="page_btn" href=\''.$link.($i* GSMS::$config['page_item_per_page']).
					'/'.($i+1)*GSMS::$config['page_item_per_page'].'\'>'.
					($i+1).'</a>';
				if($forcount>10)
					$i+=round( sqrt($mx));
				if(($i-$mx)>3 )
				{
					$body .='::<a class="page_btn" href=\''.$link.(($mx-1)* (GSMS::$config['page_item_per_page'])).
						'/'.$itemCount.'\'>'.
						($mx)  .'</a>';
				}
			}//for
			
		$body .= '	<script>
						var step = '.GSMS::$config['page_item_per_page'].';
						var url = "'.$link.'";
						function goPage(num)
						{	
							document.location = url + ((num-1)*step )  + "/" +(num*step ); 
						}
					</script>
		::<input type="text" style="width:50px" id="txtGo" value="1" /><a  class="page_btn" href="javascript:void(0)" onclick="goPage(txtGo.value)">Go</a>';
	
			
		}//if
				return $body;
	}
	
	public function head($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'head.php');
	}//fun
	public function footer($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'footer.php');
	}//fun
	public function index($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'index.php');
	}//fun
	public function intro($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'intro.php');
	}//fun
	public function panel_header($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'panel_header.php');
	}//fun
	private function fetch_sent_info($Info)
	{
		//$this->set_default_value();
		$keys=array_keys($Info);
		if (is_array($keys) AND count($keys) > 0)
		{
			foreach ($keys as $key )
			{
				//if (key_exists($key,$this->info))
					$this->info[$key]=$Info[$key];
			}//each
		}//if
		
	}//fun
	private function set_default_value()
	{	
	
		// GSMS::load('option','models'); 
		
		// list($active_theme) = GSMS::$class['option']->get_optionsByKey('theme_active');
		// if(count($active_theme)>0 )
		// {
			// list($themes) = GSMS::$class['option']->get_optionsByValue($active_theme[0]->value);
			// if(count($active_theme)>0 )
			// {
				// GSMS::$route['theme'] = $active_theme[0]->value;
			// }
		// }
		
		GSMS::$route['theme'] = 'familapp';
	
	
		if ( (!isset(GSMS::$route['theme'])) or
				(GSMS::$route['theme']=='') or
				(GSMS::$route['theme']=='default') )
		{
			$this->info['theme_url']=GSMS::$siteURL.GSMS::$outputDir.'themes/'.'default/';
			$this->info['theme_path']=GSMS::$rootDir.GSMS::$outputDir.'themes/'.'default/';
		}
		else
		{
			$this->info['theme_url']=GSMS::$siteURL.GSMS::$outputDir.'themes/'.GSMS::$route['theme'].'/';
			$this->info['theme_path']=GSMS::$rootDir.GSMS::$outputDir.'themes/'.GSMS::$route['theme'].'/';
		}//if
		
		
		$this->info['url']=GSMS::$siteURL;
		
		if((GSMS::$class['session']->checkLogin())==true)
		{
			$this->info['login']=true;
			$user=GSMS::$class['session']->getUser();
			$this->info['username']=$user['UserName'];
		}
		else
		{
			$this->info['login']=false;
			$this->info['login_url']=GSMS::$siteURL.GSMS::$index.'/login';
		}//else
		$this->info['charset']=GSMS::$charset;
		
		GSMS::$class['calendar']->farsiDigits=true;
		$this->info['datetime']= GSMS::$class['calendar']->date(" j F H:i ",time(),GSMS::$config['date_gmt']);
		$this->info['index_url']=GSMS::$siteURL.GSMS::$index.'/index/';
		$this->info['register_url']=GSMS::$siteURL.GSMS::$index.'/index/register';
		$this->info['test_url']=GSMS::$siteURL.GSMS::$index.'/telgroups/register';
		$this->info['index']=GSMS::$siteURL.GSMS::$index.'/';
		$this->info['url']=GSMS::$siteURL;
		$this->info['icon']=$this->info['theme_url'].'images/icon.icn';
		$this->info['name']='جستجو در گروه های تلگرام ';
		$this->info['describe']='گروه های تلگرام,بانک کانالهای  تلگرام,ساختن گروه تلگرام,ساختن کانال تلگرام,دانلود استیکر,استیکر با نام,گپ تلگرام,چت تلگرام,ربات تلگرام,روبات تلگرام,رباط تلگرام,';
		 
		$this->info['keyword']='telegram,جستجو و عضویت در گروه های تلگرام,تلگرام,گروه تلگرام تلگرام,استیکر,sticker,تلگرام,معرفی کانال تلگرام,معرفی گروه تلگرام,استیکر تلگرام,گروه تلگرام,کانال تلگرام,هک تلگرام,دانلود تلگرام,تبلیغات در تلگرام,ثبت کانال تلگرام,ثبت گروه تلگرام,لیست گروه های تلگرامی,لیست کانال های تلگرامی,لیست استیکر تلگرام,بانک گروه های تلگرام,بانک کانالهای  تلگرام,ساختن گروه تلگرام,ساختن کانال تلگرام,دانلود استیکر,استیکر با نام,گپ تلگرام,چت تلگرام,ربات تلگرام,روبات تلگرام,رباط تلگرام,روباط تلگرام,کمپین تبلیغاتی تلگرام';
		GSMS::$class['calendar']->farsiDigits=false;
		$this->info['date']=GSMS::$class['calendar']->date("Y-d-m ",time(),GSMS::$config['date_gmt']);
		$this->info['copyright']='www.aloosalam.com';
		$this->info['page_title']='جستجو در گروه های تلگرام';
		$this->info['align']='center';
		$this->info['activeTab']='telgroup';
		$this->info['dir']='rtl';
		$this->info['admin_url']=GSMS::$siteURL.GSMS::$index.'/admin/';
		$this->info['user_url']=GSMS::$siteURL.GSMS::$index.'/user/';
		$this->info['super_url']=GSMS::$siteURL.GSMS::$index.'/super/';
		$this->info['logout_url']=$this->info['index_url'].'logout';
		$this->info['footer_text']='تمامی فعالیت‌های این سایت تابع قوانین و مقررات جمهوری اسلامی ایران است.';
	}
}//class
?>