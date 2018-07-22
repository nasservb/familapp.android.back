<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 

class unblock
{
    function unblock()
    {
        $inf=array('page_title'=>'خروج از بلاک','title'=>'خروج از بلاک');
		GSMS::$class['template']->header($inf); 
		GSMS::$class['template']->load($inf, 'admin_header');
		 
			
			$body='<div dir=rtl>یکی از اطلاعات مدیر را وارد کنید
  <form id="user_data" name="user_data" method="post" action="'.
								GSMS::$class['template']->info['super_url'].'admins/unblock/">
     
  <table border="1" class="table table-striped">
    <tr>
      <td >شماره کاربر<br>
	  <small>
	  شماره هر کاربر در هر یک از پست های او در قسمت آخرین موارد ثبت شده یا جستجوی مورد نوشته شده است .
	  </small>
	  
	  </td>
      <td><input type="text" name="admin_id" id="admin_id" value="0" /></td>
    </tr>
    
    <tr>
      <td>همراه</td>
      <td><input type="text" name="mobile" id="mobile" value="09"/></td>
    </tr>
	<tr>
      <td>ارسال</td>
      <td><input type="submit" class="btn_send"  name="but" id="but"  value="خروج از بلاک"/></td>
    </tr>
  </table>
  </form>
</div>';
			$body.='<br/><a class="back_btn" href="'.
							GSMS::$class['template']->info['super_view'].'">برگشت</a>';
			$inf['body']= $body;
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}