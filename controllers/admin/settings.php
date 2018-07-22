<?php //allahoma sale ala mohammad va ale mohammad 
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 
class settings 
{
	
 	public function __construct()
	{
		if (GSMS::$class['session']->checkLogin()==false|| GSMS::$class['session']->checkAdmin()==false)
			GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
		GSMS::load('template','core');
		GSMS::$class['system_log']->log('DEBUG','settings class started successfull');
	}
	function index()
	{
		//$this->propertyName=$propertyValue;
	}//fun
	
	function commentAccept($id)
	{
		GSMS::load('comment', 'models');

        $tempComment =GSMS::$class['comment']->getComment($id);
		
        $inf = array('page_title' => 'تایید نظر');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'تایید نظر');
        GSMS::$class['template']->panel_header($inf);
		
         if(!is_object($tempComment))
        {
			 $body = '<div dir="rtl" class="alert alert-warning"> نظر یافت نشد.</div>';
           
        }
		else
		{
			$tempComment->accepted = true; 
			$tempComment->save();
			
			$body = '<div dir="rtl" class="alert alert-info">نظر با موفقیت تایید شد .</div>';
            
		}
		$inf = array(
					'title' =>'تایید نظر', 
					'body' => $body.
					'<br/><a class="back_btn" href="'
						. GSMS::$class['template']->info['admin_url'] . 
						'settings/comments">برگشت</a>',
					'dir' => 'ltr');
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
	}
	
    function commentDelete($id)
    {
		GSMS::load('comment', 'models');

        $tempComment =GSMS::$class['comment']->getComment($id);
		
        $inf = array('page_title' =>'مشاهده نظر');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' =>'مشاهده نظر');
        GSMS::$class['template']->panel_header($inf);
		
        if(!is_object($tempComment)|| !$tempComment->deleteComment())
        {
			 $body = '<div dir="rtl" class="alert alert-warning"> نظر یافت نشد.</div>';
           
        }
		else
		{
			$body = '<div dir="rtl" class="alert alert-info">نظر با موفقیت حذف شد .</div>';
            
		}
		$inf = array(
					'title' =>'مشاهده نظر', 
					'body' => $body.
					'<br/><a class="back_btn" href="'
						. GSMS::$class['template']->info['admin_url'] . 
						'settings/comments">برگشت</a>',
					'dir' => 'ltr');
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
    }

    function commentView($id)
    {
		GSMS::load('comment', 'models');

        $inf =GSMS::$class['comment']->getComment($id);
		
        GSMS::load('view_comment', 'admin_view', 'settings', $inf);
    }

    function comments($begin = 0, $end = 30)
    {
        GSMS::load('comment', 'models');
        $user=GSMS::$class['session']->getUser();

        $inf['comments'] =GSMS::$class['comment']->searchComment(
					'',//$Name=
					'',//$BeginCreateDate=
					'',//$EndCreateDate=
					0,//$ItemId=
					'', //$ItemType=
					'',//$Content=
					0,//$UserId=
					$begin,
					$end,
                   0 );//$accepted=0
		
        GSMS::load('list_comment', 'admin_view', 'settings', $inf);

    }

    function unacceptedComments($begin = 0, $end = 30)
    {

        GSMS::load('comment', 'models');
        $inf['comments'] =GSMS::$class['comment']->getUnacceptedComment($begin,$end);

        GSMS::load('unaccepted_comment', 'admin_view', 'settings', $inf);
    }

	
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}