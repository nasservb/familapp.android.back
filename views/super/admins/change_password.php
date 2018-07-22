<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 

class change_password
{
    function change_password()
    {
      //free result
			$inf=array('page_title'=>'تغییر رمز');
			GSMS::$class['template']->header($inf);
			$inf=array('page_title'=>'صفحه ی مدیریت ');
			GSMS::$class['template']->load($inf, 'admin_header');
			//----------------------------------
			
			$body='<div dir=rtl>اطلاعات رمز
			<form id="user_data" name="user_data" method="post" action="'.
								GSMS::$class['template']->info['admin_url'].'admins/change_password">
  <table border="1" class="input_table">
    <tr>
      <td >رمز فعلی</td>
      <td><input type="password" name="oldpass" id="oldpass" value="" /></td>
    </tr>
    <tr>
      <td>رمز جدید</td>
      <td><input type="password" name="newpass" id="newpass" value=""/></td>
    </tr>
	<tr>
      <td>تکرار رمز جدید</td>
      <td><input type="password" name="newpass_again" id="newpass_again" value=""/></td>
    </tr>	
	<tr>
      <td>ارسال</td>
      <td><input type="submit" class="btn_send"  name="but" id="but"  value="ثبت"/></td>
    </tr>
  </table>
  </form>
</div>';
			$body.='<a class="back_btn" href="'.
							GSMS::$class['template']->info['admin_url'].'">برگشت</a>';
			$inf=array('title'=>'تغییر رمز ','body'=>$body,'dir'=>'ltr');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}