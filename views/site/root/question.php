<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class question
{
	
    public function question(  )
    {
		 
		$body='<div  style="padding: 19px;  line-height: 25px;">
		<div class="message-info">
		در دست تهیه<br/>		
		</div>
		</div><br/>
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		';
		
		 
		GSMS::$class['template']->message('سوالات متداول'  ,$body,'site',"",false,false); 
		 
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}