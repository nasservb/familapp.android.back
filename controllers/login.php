<?php //allahoma sale ala mohammad va ale mohammad 
//class for give login value on view(presenation) layer start 3-2-91 by nasser niazy in 



class login
{
	public function __construct()
	{
		//constructor
		if (! isset(GSMS::$class['template']))
			GSMS::load('template','core');
	}//fun
	
	public function index($wizard =0 )
	{
		$message = ''; 
		if (GSMS::$class['session']->checkLogin()==true)
		{
			$user=GSMS::$class['session']->getUser();
			if($user['UserType'] == 3)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/super/index");
				return;
			}
		}
		
		
		$UserName = GSMS::$class['input']->post('Uname');
		$Pass= GSMS::$class['input']->post('Pass');
		
		if( isset($_POST['submit'])) 
		{
			GSMS::load('Fox_captcha','lib','','require');
			$img = new Fox_captcha(120, 30, 5);
			$message='';
			if(($_POST['captcha_enabled']==1 || GSMS::$class['session']->get('login_count') > 1)  && !$img->test(GSMS::$class['input']->post('captcha')))
			{
				$message= 'عبارت امنیتی به درستی وارد نشده است <br/>در صورت نامفهوم بودن عبارت امنیتی از گزینه بارگذاری مجدد استفاده کنید .' ; 
				GSMS::load('register','site_view','users',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
				return;
			}
			
			$log=GSMS::$class['session']->login($UserName,$Pass);
			if ($log==45)
			{
				$user=GSMS::$class['session']->getUser();
				
				 if($user['UserType'] == 3)
				{
					GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/super/index");
					return;
				}
				 
				
			}
			
			
			switch ($log){
				case 500: 
						$message='نام کاربری یا رمز عبور مقدار دهی نشده است.';
						
						break;
				case 309: 
						$message='به دلایل امنیتی متاسفانه مجوز های ورود شما موقتآ لغو شده . <br/>
						پس از وقفه ای 15 دقیقه ای می توانید دوباره برای ورود تلاش کنید . در صورت بروز هرگونه مشکل از گزینه تماس با ما در پایین صفحه با ما مکاتبه کنید 
						';
						break;
				case 303: 
						$message= 'نام کاربری یا رمز عبور صحیح نیست<br/>['.GSMS::$class['session']->get('login_count') .'/5]شما از یکی از مجوزهای خود استفاده کردید';
						break;
				case 304:
						$message='سایت در حال بروزرسانی است لطفآ در زمان دیگری تلاش نمایید';
						break;
			}//switch  
			GSMS::load('register','site_view','frontpage',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
			return;
		}
		else
		{
			GSMS::load('register','site_view','frontpage',array('wizard'=>$wizard));
		}//if
	}//func
}//class	
 
?>
