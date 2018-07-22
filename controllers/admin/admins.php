<?php //allahoma sale ala mohammad va ale mohammad 
//class admin for all administrator managment choice on view layer start 11-2-91 by nasser niazy in 
class admins 
{
	
 	public function __construct()
	{
		if (GSMS::$class['session']->checkLogin()==false || GSMS::$class['session']->checkAdmin()==false )
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
		GSMS::load('template','core');
		GSMS::$class['system_log']->log('DEBUG','admins class started successfull');
	}
	
	function index()
	{
		$this->propertyName=$propertyValue;
	}//fun
	function edit_admin($adminid)
	{
		$name = GSMS::$class['input']->post('name');
		GSMS::load('admin','models');
		if(!isset($_POST['but']))
		{
			 $user = GSMS::$class['session']->getUser();
            
			$tempAdmin=admin::getAdmin( $user['UserID']);
			GSMS::load('edit_admin','admin_view','admins',$tempAdmin);
			
		}
		else
		{
			$tempAdmin=& admin::getAdmin(GSMS::$class['input']->post('admin_id'));
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');//family
			$tempAdmin->mail=GSMS::$class['input']->post('mail');
			$tempAdmin->userName=GSMS::$class['input']->post('username');
			$tempAdmin->describe=GSMS::$class['input']->post('describe');
			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
			$tempAdmin->adminType=1;
	
			$result=$tempAdmin->save();
			$inf=array('page_title'=>'ویرایش مدیر');
			GSMS::$class['template']->header($inf);
			$inf=array('page_title'=>'صفحه ی مدیریت ');
			GSMS::$class['template']->panel_header($inf);
			if($result==1)
				$body='مدیر با موفقیت ویرایش شد';
			else
				$body='مدیر ویرایش نشد';
					
			$body .='<br><a class="back_btn" href="'.
						GSMS::$class['template']->info['admin_url'].
						'admins/list_admins">برگشت</a>';
			$inf=array('title'=>' ویرایش مدیر','body'=>$body,'dir'=>'ltr');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
			unset($tempAdmin);
		}//if
	}//func
	function view_admin($adminid)
	{
		if(intval($adminid)==0)
			$adminid=intval( GSMS::$class['input']->get('id'));
		
		//free result
		GSMS::load('admin','models');
		$tempAdmin=admin::getAdmin($adminid);
		GSMS::load('view_admin','admin_view','admins',$tempAdmin);
		
	}
	function list_admins($begin=0,$end=0)
	{
		GSMS::load('admin','models');	
		$tempAdmins = admin::listAdmins(1,$begin,$end);
		GSMS::load('list_admin','admin_view','admins',$tempAdmins);
	}//func
	
	function change_password()
	{
		$oldpass = GSMS::$class['input']->post('oldpass');
		GSMS::load('admin','models');
		if($oldpass=='')
		{
			GSMS::load('change_password','admin_view','admins');
		}
		else
		{
			$inf=array('page_title'=>'ویرایش رمز عبور');
			GSMS::$class['template']->header($inf);
			$inf=array('page_title'=>'صفحه ی مدیریت ');
			GSMS::$class['template']->panel_header($inf);
			//--------------------------------------------			
			$oldpass=GSMS::$class['input']->post('oldpass');
			$newpass=GSMS::$class['input']->post('newpass');
			$newpass2=GSMS::$class['input']->post('newpass_again');
			if($newpass=='' || $newpass2=='' || $oldpass=='')
			{
				$body ='یکی از رمز ها وارد نشده است<br><a class="back_btn" href="'.
						GSMS::$class['template']->info['admin_url'].
						'admins/list_admins">برگشت</a>';
			$inf=array('title'=>' ویرایش مدیر','body'=>$body,'dir'=>'ltr');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
			}
			if($newpass!=$newpass2)
			{
				$body ='رمز ها با هم متابق نیستند<br><a class="back_btn" href="'.
						GSMS::$class['template']->info['admin_url'].
						'admins/list_admins">برگشت</a>';
				$inf=array('title'=>' ویرایش مدیر','body'=>$body,'dir'=>'ltr');
				GSMS::$class['template']->index($inf);
				GSMS::$class['template']->footer($inf);
			}//if
			$result= admin::changePass($oldpass,$newpass);
			switch ($result)
			{
				case 309:$body='تعداد تلاش مجاز شما تمام شده';break;
				case 500:$body='نام کاربر یا رمز عبور مقداردهی نشده';break;
				case 303:$body='رمز عبور صحیح نیست';break;
				case 304:$body='زمان دیگری تلاش کنید ';break;
				case 45:$body='رمز با موفقیت ویرایش شد';break;
			}//swithc
			$body .='<br><a class="back_btn" href="'.
						GSMS::$class['template']->info['admin_url'].
						'">برگشت</a>';
			$inf=array('title'=>' ویرایش رمز عبور','body'=>$body,'dir'=>'ltr');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
		}//if
	}//func
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
