<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 

class edit_admin
{
    function edit_admin($tempAdmin)
    {
       $inf=array('page_title'=>'ویرایش مدیر');
		GSMS::$class['template']->header($inf);
		$inf=array('page_title'=>'صفحه ی مدیریت ');
		GSMS::$class['template']->load($inf, 'admin_header');
		if(!is_object($tempAdmin))
		{
			$body='اطلاعات مدیری یافت نشد<br>
						<a class="back_btn" href="'.
						GSMS::$class['template']->info['admin_url'].'admins/list_admins">برگشت</a>';
			$inf=array('title'=>'ویرایش مدیر','body'=>$body,'dir'=>'ltr');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
			exit();
		}//if
			
			$body='<div dir=rtl>اطلاعات مدیر را وارد کنید
  <form id="user_data" name="user_data" method="post" action="'.
								GSMS::$class['template']->info['admin_url'].'admins/edit_admin/0">
    <input type="hidden" name="admin_id" id="admin_id"  value="'.$tempAdmin->id.'"/>
  <table border="1" class="input_table">
    <tr>
      <td >نام*</td>
      <td><input type="text" name="name" id="name" value="'.$tempAdmin->name.'" /></td>
    </tr>
    <tr>
      <td>نام خانوادگی*</td>
      <td><input type="text" name="family" id="family" value="'.$tempAdmin->family.'"/></td>
    </tr>
    <tr>
      <td>ایمیل*</td>
      <td><input type="text" name="mail" id="mail" value="'.$tempAdmin->mail.'"/></td>
    </tr>
    <tr>
      <td>نام کاربری</td>
      <td><div class="disable_input">'.$tempAdmin->userName.'</div></td>
    </tr>
    <tr>
      <td>همراه</td>
      <td><input type="text" name="mobile" id="mobile" value="'.$tempAdmin->mobile.'"/></td>
    </tr>
    <tr>
      <td>تاریخ ثبت</td>
      <td><div class="disable_input">'.$tempAdmin->date.'</div></td>
    </tr>
    <tr>
      <td>توضیح</td>
      <td><input type="text" name="describe" id="describe" value="'.$tempAdmin->describe.'"></td>
    </tr>
    
   
    
	<tr>
      <td>ارسال</td>
      <td><input type="submit" class="btn_send"  name="but" id="but"  value="ثبت"/></td>
    </tr>
  </table>
  </form>
</div>';
			$body.='<br/><a class="back_btn" href="'.
							GSMS::$class['template']->info['admin_url'].'">برگشت</a>';
			$inf=array('title'=>'ویرایش مدیر ','body'=>$body,'dir'=>'ltr');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}