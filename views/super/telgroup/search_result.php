<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in 

class search_result
{

    function search_result($tempGroupArray)
    {

        $inf = array('page_title' => 'نتايج جستجو ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'نتايج جستجو ');
        GSMS::$class['template']->load($inf, 'super_header');

        list($tempGroup, $begin, $itemCount) = $tempGroupArray;
		
		
		$body = '<a class="btn btn-primary" href="' . GSMS::$class['template']->info['super_url'] . 'telgroups/search">جستجوي پيشرفته</a><br/>';

        
        if (count($tempGroup) == 0) {
            $body .= '<div class="alert alert-warning"> موردي يافت نشد</div><a class="back_btn" href="'
                . GSMS::$class['template']->info['super_url'] . '">برگشت</a>';
            $inf = array('title' => 'نتايج جستجو ', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
        $body .= '<div class="row" dir="rtl"><tr>';
        $body .= '  <link rel="stylesheet" href="' . GSMS::$class['template']->info['url'] . 'panel/views/css/jquery.raty.css" media="all" rel="stylesheet" type="text/css"/>
					<script src="' . GSMS::$class['template']->info['url'] . 'panel/views/js/jquery.raty.js" type="text/javascript"></script>
					';

        $date = '';

       
        GSMS::load('input', 'core');
        

        $body .= ' 
		
		
		
		<br/>';
		
        for($i=0;$i< count($tempGroup);$i++)
		{
			
			 $body .= '
			
			<div class="music_item"  '.($tempGroup[$i]->isAccepted != 14 ? 'style="background:#D0D0D0"' : '' ).'>
				
				<a href="' . GSMS::$class['template']->info['index'] . 'telgroups/telgroupView/' . $tempGroup[$i]->id . '">
					<div class="bicBox">
						<img class="music_cover"
							id="img' . $i . '"  width="50"  height="40"
							src="'.GSMS::$class['template']->info['index_url'].'iconGroupView/' .
							$tempGroup[$i]->iconPictureId. '/'.$tempGroup[$i]->telgroupTypeId . '"/>
					</div>
					<div class="music_title" ><a  target="_blank"  class="btn btn" href="' . 
					 $tempGroup[$i]->telegramAddress . '">   ' . $tempGroup[$i]->title . '</a></div>
					<div class="music_owner" > ' . substr($tempGroup[$i]->description,0, 200 ) . '</div>
					<div class="music_date" >' . substr($tempGroup[$i]->createDate, 0, 10) . '</div>
				</a>	
				<div class="music_rate">
					  ' . $tempGroup[$i]->userId . ' 
				</div>	
				
				<a  target="_blank"  class="btn btn-danger" href="' . 
					GSMS::$class['template']->info['super_url'] . 'telgroups/block/' . ($tempGroup[$i]->id*34) . '">بلاک</a>'.
				(
				($tempGroup[$i]->isAccepted == 1 ) ? 		
				('<a  target="_blank"  class="btn btn-warning" href="' . 
					GSMS::$class['template']->info['super_url'] . 'telgroups/remove/' . ($tempGroup[$i]->id*34) . '">حذف</a>' )
					: 
				'<a target="_blank" class="btn btn-success" href="' . 
					GSMS::$class['template']->info['super_url'] . 'telgroups/accept/' . ($tempGroup[$i]->id*34) . '">تاييد</a>' 
				)
				.  '
			<script>$("#input' . $tempGroup[$i]->id . '").raty({ half: true ,readOnly: true});</script>	
			</div>';

		}
		if($itemCount > 1000) 
		{
			$itemCount= $begin   + 1000;
		}
		
		$body .= '</div>';
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['super_url'] .  'telgroups/search_result/', $begin, $itemCount);

         $body .= ' </div>
		  <br/>
		  <a class="back_btn" href="' . GSMS::$class['template']->info['super_url'] . '">برگشت</a>
		  
		  ';
            
			$inf = array('title' =>'نتايج جستجو ', 'body' => $body);
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
	}
	
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}