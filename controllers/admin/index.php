<?php //allahoma sale ala mohammad va ale mohammad
//class contain all admin function on view layer start 4-2-91 by nasser niazy in 
class index
{
	private $User;
	public function __construct()
	{
		if (GSMS::$class['session']->checkLogin()==false|| GSMS::$class['session']->checkAdmin()==false)
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
		if(!isset(GSMS::$class['template']))
			GSMS::load('template','core');
		$this->User=GSMS::$class['session']->getUser();
		
		if(intval($this->User['UserType']) == 3)
		{
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/super/index");
			return;
		}
		elseif(intval($this->User['UserType'] )== 2)
		{
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/index");
			return;
		}
			
	}//fun
	public function logout()
	{
		GSMS::$class['session']->logout();
		GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
	}	
	public function index()
	{
		$inf=array('page_title'=>'صفحه ی مدیریت');
		GSMS::$class['template']->header($inf);
		$inf=array('page_title'=>'صفحه ی مدیریت مدیران');
		GSMS::$class['template']->load($inf,'admin_header');
		$user=GSMS::$class['session']->getUser();
		$body='';
		
		 
		$body.='
		
		<div class="tools"><div class="tools_title">امکانات اصلی</div>
			
			<div class="toolsbox">
			<table><tr>
				<td align="center"><a class="tools_link" href="index/logout" ><div id="logout_photo"></div>خروچ</a></td>
				<td align="center"><a class="tools_link" href="telgroups/search" ><div id="search_music"></div>جستجوی مورد</a></td>
				
				<td align="center"><a class="tools_link" href="telgroups/lastTelgroup" ><div id="start_race"></div>آخرین موارد ثبت شده</a></td>
					
						
			</tr></table>
			</div>
		</div><br/>
		
		
		
		<div align="center" class="tools"><div class="tools_title">مدیران</div>
			<div class="toolsbox">
			<table><tr>
				<td align="center"><a class="tools_link" href="admins/edit_admin" ><div id="edit_admin"></div>ویرایش پروفایل</a></td>
				<td align="center"><a class="tools_link" href="admins/change_password" ><div id="change_password"></div>تغییر رمز</a></td>			
			</tr></table>
			</div>
		</div><br/>
		';
		$inf=array('title'=>'امکانات','body'=>$body,'dir'=>'ltr');
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
	}//func index

	public function home($begin =0,$end=30)
	{
		GSMS::load("music", 'models');
		
		$tempMusics = GSMS::$class['music']->listMusics($begin, $end );
		
		GSMS::load('home','admin_view','music',$tempMusics);
	}
}//class
?>
