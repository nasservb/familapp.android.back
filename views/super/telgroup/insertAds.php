<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 

class insertAds
{
    function insertAds($parameter)
    {
		
        $inf = array('page_title' => 'ثبت تبلیغ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'ثبت تبلیغ ');
        GSMS::$class['template']->load($inf,'super_header');
		
		$category_body = '';
        $categorys = $parameter['telgroupCategory'];
        for ($i = 0; $i < count($categorys); $i++)
            $category_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['title'] . '</option>' . '\n';

		$ostan_body = '<option value=0>همه استان ها</option>';
        $categorys = $parameter['ostan'];
        for ($i = 0; $i < count($categorys); $i++)
            $ostan_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['name'] . '</option>' . '\n';

        $body = '
		<br/>
		
		<script>
			function getShar(ostanid)
			{
			
				if(ostanid == 0)
				{
					
					return;
				}
				$("#shahr").load("'.GSMS::$class['template']->info['index'].'telgroups/getShahr/"+ostanid, function(responseTxt, statusTxt, xhr){
					if(statusTxt == "success")
						;
					if(statusTxt == "error")
					{
						
						document.getElementById("notif").innerHTML="<div class=\"message-info\">خطا در ارتباط با سرور: " + xhr.status + ": " + xhr.statusText+"</div>";
					}
				});
			}
		</script>
		
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#createDate").persianDatepicker();            
			});
		</script>
		<form action="' . GSMS::$class['template']->info['super_url'] . 'telgroups/insertAds" method="post" enctype="multipart/form-data">
		<div id="notif"></div>
       <table dir="rtl">
	 
        <tr><td>نام تبلیغ	</td>
		<td><input type="text" name="name" id="name" /></td></tr>
        <tr><td>متن کوتاه درباره تبلیغ:</td>
		<td><textarea type="text" name="description" id="description" ></textarea></td></tr>
        <tr><td>آدرس تبلیغ : شبیه(https://telegram.me/)</td>
		<td><input type="text" name="address" id="address" /></td></tr>
        <tr>
			<td>دسته بندی</td>
			<td>
				<select name="category" id="category" >
				' . $category_body . '
				</select>
			</td>
		</tr>
        <tr><td>هشتگ مثل: #عاشقانه#دخترانه</td>
		<td><input type="text" name="tag" id="tag" /></td></tr>
        <tr><td>استان </td>
		<td>
			<select name="ostan" id="ostan"  onchange="getShar(this.value)">
				' . $ostan_body . '
				</select>
		</td>
		</tr>
        <tr><td>شهر</td>
		<td >
				<select name="shahr" id="shahr">
					<option value=0>همه شهر ها</option>
				</select>
		</tr>
        <tr><td>موبایل یا آی دی ادمین کانال</td>
		<td><input type="text" name="owner_mobile" id="owner_mobile" /></td></tr>
        <tr><td>  تعداد اعضاء</td>
		<td><input type="text" name="member" id="member" /></td></tr>
		
		<tr><td title="در صفحه کانال این تصویر به عنوان پس زمینه استفاده می شود">
		کاور بزرگ کانال</td><td><input  title="در صفحه کانال این تصویر به عنوان پس زمینه استفاده می شود" type="file" name="cover" id="cover" />
					<img src="'.GSMS::$class['template']->info['index_url'].'coverGroupView/0"/>
					</td></tr>
        <tr><td  title="در لیست کانال هااین تصویر به عنوان پس زمینه استفاده می شود">
		تصویر کوچک کانال</td><td><input  title="در لیست کانال هااین تصویر به عنوان پس زمینه استفاده می شود" type="file" name="icon" id="icon" />
					<img src="'.GSMS::$class['template']->info['index_url'].'iconGroupView/0"/>
		</td></tr> 
		
		<tr><td>  تاریخ ایجاد کانال </td>
		<td><input type="text" name="createDate" id="createDate" /></td>
		</tr>
		
        <tr><td><input type="submit" class="btn btn-success btn-register" name="send" id="send" value="ثبت " /></tr>
		</table>
        </form><br/>
		
		
		<a class="back_btn" href="' . GSMS::$class['template']->info['super_url'] . '">برگشت</a>
		';

        $inf = array('title' => 'ثبت کانال ', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}