<?php //allahoma sale ala mohammad va ale mohammad
//class contain all admin function on view layer start 4-2-91 by nasser niazy in 
class index
{
	private $User;
	
	public function __construct()
	{
		// if (GSMS::$class['session']->checkLogin()==false)
			// GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
		if(!isset(GSMS::$class['template']))
			GSMS::load('template','core');
		$this->User=GSMS::$class['session']->getUser();
		
		if(intval($this->User['UserType']) == 1)
		{
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/admin/index");
			return;
		}
		elseif(intval($this->User['UserType']) == 2)
		{
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/index");
			return;
		}
		// elseif(intval($this->User['UserType']) == 3)
		// {
			// GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/super/index");
			// return;
		// }
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
		<div class="tools"><div class="tools_title">کانالهای تایید شده</div>
			<div class="toolsbox">
			<table dir="rtl"><tr>
				
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['admin_url'] 
						.'telgroups/insertTelchannel" ><div id="addChannel"></div>ثبت کانال تایید شده</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['admin_url'] 
						.'telgroups/listTelchannel" ><div id="listChannel"></div>لیست کانال های تایید شده</a></td>
				
				</table>
			<br/>
			</div>
		</div><br/>
		<div class="tools"><div class="tools_title">امکانات اصلی</div>
			
			<div class="toolsbox">
			<table><tr>
				<td align="center"><a class="tools_link" href="index/logout" ><div id="logout_photo"></div>خروچ</a></td>
				<td align="center"><a class="tools_link" href="telgroups/search" ><div id="search_music"></div>جستجوی مورد</a></td>
				
				<td align="center"><a class="tools_link" href="telgroups/lastTelgroup" ><div id="start_race"></div>آخرین موارد ثبت شده</a></td>
				
				<td align="center"><a class="tools_link" href="telgroups/lastAcceptedTelgroup" ><div id="start_race"></div>تایید شده ها</a></td>
				
					<td align="center"><a class="tools_link" href="settings/comments" >
					<div id="user_request"></div>آخرین نظرات </a></td>
					
						
			</tr></table>
			</div>
		</div><br/>
		
		
		
		<div align="center" class="tools"><div class="tools_title">ریپورت</div>
			<div class="toolsbox">
			<table><tr>
				<td align="center"><a class="tools_link" href="admins/unblock" ><div id="edit_admin"></div>خروج کاربر از ریپورت</a></td>
				<td align="center"><a class="tools_link" href="admins/edit_admin" ><div id="edit_admin"></div>ویرایش پروفایل</a></td>
				<td align="center"><a class="tools_link" href="admins/change_password" ><div id="change_password"></div>تغییر رمز</a></td>			
			</tr></table>
			</div>
		</div><br/>
		
		
		
		<div align="center" class="tools"><div class="tools_title">تبلیغات</div>
			<div class="toolsbox">
			<table>
			<tr>
				<td align="center"><a class="tools_link" href="telgroups/ads" ><div id="list_tags"></div>لیست تبلیغات</a></td>
				<td align="center"><a class="tools_link" href="telgroups/insertAds" ><div id="list_tags"></div>افزودن تبلیغات</a></td>	
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
