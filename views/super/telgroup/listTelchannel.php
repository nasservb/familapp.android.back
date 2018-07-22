<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 

class listTelchannel
{

    function listTelchannel($tempGroupArray)
    {

        $inf = array('page_title' => 'لیست کانال ها ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'لیست کانال ها ');
        GSMS::$class['template']->load($inf, 'super_header');

		
        list($tempGroup, $begin, $itemCount) = $tempGroupArray;
		
		if (count($tempGroup) == 0) {
            $body = 'کانالی یافت نشد<br/><a class="back_btn" href="'
				. GSMS::$class['template']->info['super_url'] . '">برگشت</a>';
			$inf = array('title' => 'لیست کانال ها ', 'body' => $body);
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
		
        $body = '<div class="row" dir="rtl"><tr>';
        $body .= '  <link rel="stylesheet" href="' . GSMS::$class['template']->info['url'] . 'panel/views/css/jquery.raty.css" media="all" rel="stylesheet" type="text/css"/>
					<script src="' . GSMS::$class['template']->info['url'] . 'panel/views/js/jquery.raty.js" type="text/javascript"></script>
					';
        $date = '';

       
        $body .= ' <br/>';

        for ($i = 0; $i < count($tempGroup); $i++) 
		{
            $body .= '
			
			<div class="music_item">
				
				<a href="' . GSMS::$class['template']->info['index'] . 'telgroups/telgroupView/' . $tempGroup[$i]->id . '">
					<div class="bicBox">
						<img class="music_cover"
							id="img' . $i . '"  width="50"  height="40"
							src="'.GSMS::$class['template']->info['index_url'].'iconGroupView/' .
							$tempGroup[$i]->iconPictureId. '/'.$tempGroup[$i]->telgroupTypeId . '"/>
					</div>
					<div class="music_title" >   ' . $tempGroup[$i]->title . '</div>
					<div class="music_owner" > ' . substr($tempGroup[$i]->description,0, 200 ) . '</div>
					<div class="music_date" >' . substr($tempGroup[$i]->createDate, 0, 10) . '</div>
				</a>	
				<div class="music_rate">
					  ' . $tempGroup[$i]->userId . ' 
				</div>	
				
			'.
				(
				($tempGroup[$i]->isAccepted == 1 ) ? 		
				('<a  target="_blank"  class="btn btn-warning" href="' . 
					GSMS::$class['template']->info['super_url'] . 'telgroups/remove/' . ($tempGroup[$i]->id*34) . '">حذف</a>' )
					: 
				'<a target="_blank" class="btn btn-success" href="' . 
					GSMS::$class['template']->info['super_url'] . 'telgroups/accept/' . ($tempGroup[$i]->id*34) . '">تاييد</a>' 
				)
				.  '
				<a class="btn btn-primary" href="' . GSMS::$class['template']->info['super_url'] . 'telgroups/editTelchannel/' .
				$tempGroup[$i]->id . '">ویرایش</a>
			
			</div>';

        }
        //for
		
		$body .='</div>
		  <br/>'. GSMS::$class['template']->paging(
            GSMS::$class['template']->info['super_url'] .  'telgroups/listTelchannel/', $begin, $itemCount);

         $body .= ' </div>
		  <br/>
		  <a class="back_btn" href="' . GSMS::$class['template']->info['super_url'] . '">برگشت</a>
		  
		  ';


        $inf = array('title' => 'لیست کانال ها', 'body' => $body);
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->load($inf, 'site_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}