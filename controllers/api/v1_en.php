<?php  //allahoma sale ala mohammad va ale mohammad

class v1_en
{
	private $user ; 
	
    public function __construct()
    { 
		GSMS::$config['db_databasename'] = 'familap1_en';
		GSMS::$config['db_databaseuser'] = 'familap1_en';
		GSMS::$config['db_databasepass'] = 'LDWfCrH4JVewSmJcgLbf';
		
		R::debug(true);
		R::addDatabase('familap1_en', 'mysql:host=localhost;dbname=familap1_en', 'familap1_en','LDWfCrH4JVewSmJcgLbf');
		R::selectDatabase('familap1_en');

		// R::setup( 'mysql:host='.GSMS::$config['db_hostname'].
					// ';dbname='.GSMS::$config['db_databasename'],
					// GSMS::$config['db_databaseuser'], 
					// GSMS::$config['db_databasepass'] ); //for both mysql or mariaDB
					
		R::exec('SET NAMES utf8');
		
		GSMS::$class['DB'] = new DB(); 
		
    }
	
 
 	public function iconView($id=0,$type=1)
	{
		
		GSMS::load('picture','models');
		
		$photo =R::dispense('picture');
		$photo = R::load('picture',$id);
		
		$path='';
		
		if($photo == 404 ||$id== 0)
		{
			switch($type)
			{
				case 1: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupIcon.png";break;
				case 2: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telidIcon.png";break;
				case 3: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telstickerIcon.png";break;
				case 4: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telrobotIcon.png";break;
				case 7: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telchannelIcon.png";break;
				case 9: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/adsIcon.png";break;
				default: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupIcon.png";break;
			}
		}
		else
		{
			$path=GSMS::$config['photo_archive_path'].$photo->picture_path;
		}
		
		if($type ==11 )
			return $this->loadImage($path,false);
		else  
			return $this->loadImage($path,($id!=6767));
		
		
	}
	
	private function loadImage($path,$mini =false)
	{
		
	
	   // File Exists? 
	   if( file_exists($path) )
	    {
			
			//$im = imagecreatefrompng($path);
			$im=null;
			$gis        = getimagesize($path );
			$type        = $gis[2];
			header("Cache-Control: private, max-age=10800, pre-check=10800");
			header("Pragma: private");
			header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
			switch($type)
			{
				 case "1": 
					header('Content-type: image/gif');
					$im = imagecreatefromgif($path); 
					break;
				 case "2": 
					header('Content-type: image/jpeg');
					$im = imagecreatefromjpeg($path);
					break;
				 case "3": 
					
					header('Content-type: image/png');
					$im = imagecreatefrompng($path); 
					imagealphablending($im, true);
					
					break;
				 default: continue ;
			}
			if($mini == true)
			{
				$new_width=GSMS::$config['photo_small_width'];
				$new_height=GSMS::$config['photo_small_height'];
				
				$width = imagesx($im); 
				$height = imagesy($im);
				
				$thumb = imagecreatetruecolor($new_width, $new_height);
				imagealphablending($thumb, true);
				imagesavealpha($im, true);
				
				//$new_image = imagecreatetruecolor($new_width,$new_height); 
				
				
				//ImageCopyResized($new_image, $im,0,0,0,0, $new_width, $new_height, $width, $height);
				imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagepng($thumb );
				
				header("Content-Disposition: inline; filename=".basename($path));
				imagedestroy($new_image);
				imagedestroy($im);
				return;
			}
		
			header("Content-Disposition: inline; filename=".basename($path));
			imagepng($im );
			imagedestroy($im);

		} else 
			die('File Not Found:'.$path);
	}
	
	
	public function checkToken()
	{
		if (!isset($_REQUEST['token']))
			exit('access denied');
		
		GSMS::load('admin','models'); 
        $user  =new admin ; 
		$this->user = $user->getAdminByToken($_REQUEST['token']);
		
		if(!is_object($this->user))
		{
			exit('access denied');
		}
        
	}
	
	public function sendLike($group_id)
	{
		$this->checkToken();
		
		$like = GSMS::$class['input']->post('liek');
		
		GSMS::load('visit','models');
		GSMS::$class['visit']->log('mobileSendLike',$like);
		
		if (isset($_POST['pass']) && $_POST['pass'] == '1266')
		{
			GSMS::load('telgroup','models');

			
			$inf=GSMS::$class['telgroup']->getTelgroup($group_id);
			
			if ($like  == 'plus') 
				$inf->likeCount =intval($inf->likeCount) + 1;
			else 
				$inf->likeCount =intval($inf->likeCount) - 1;
			
			if ($inf->likeCount < 0 )
				$inf->likeCount=0;
			
			$inf->calcRate =intval($inf->calcRate) + 1;
			
			$inf->save();
			
			echo (json_encode(1));
		}
		else 
			echo (json_encode(0));

	}

	public function linkBroken($group_id)
	{
		$this->checkToken();
		
		GSMS::load('visit','models');
		GSMS::$class['visit']->log('mobileBrokenLink',$group_id. print_r($_POST,true));
		 
			
		 
		GSMS::load('telgroup','models');
		GSMS::load('admin','models');

		$user_id = GSMS::$class['input']->post('user');
		
		$inf=GSMS::$class['telgroup']->getTelgroup($group_id/34);
		$user=GSMS::$class['admin']->getAdmin($user_id);
		
		
		if ($inf->telgroupTypeId == 1) 
		{
			$inf->isDeleted=intval($inf->isDeleted)+1;
			
		}
		else 
		{
			$inf->isDeleted=intval($inf->isDeleted)+1;
			//if ($inf->isDeleted >=5) 
				//$inf->isAccepted =0;
		}
		
		if(intval(GSMS::$class['input']->post('delete')) == 1)
			$inf->isDeleted =1;
			
		if ($user->adminType == 1 ||  $user->adminType == 3 ) 
				$inf->isAccepted =0;
		
		if($inf->isVIP == 0 && $inf->isSuperGroup ==0)
			$inf->save();
		else 
			$inf->isDeleted=intval($inf->isDeleted)+1;
		
		
			
		echo (json_encode(1));
		 
	}

    function index()
    {
		
        echo (json_encode('hello world!'));
    }
     	 
	function search($begin = 0, $end = 30)
    {
		$this->checkToken();
		
		$end = ($end ==30 ? 50 : $end); 
		 
		GSMS::load('visit','models');
		
		$data=  
				'q:' . 	GSMS::$class['input']->post('q') . 
				',l:' . 	GSMS::$class['input']->post('sort') . 
				 ',o:' .intval($_POST['ostan']).
				 ',s:'.intval($_POST['shahr']);
				 
		GSMS::$class['visit']->log('mobileSearch',$data,$this->user->id);
	 
		GSMS::load("shajarename", 'models');
         
		$selectedType  =1;
		$accept=1;
		$selectedSort  =5;
		$vip =-1;
		$super = -1;
		$user=0;
		$parentId = intval(GSMS::$class['input']->post('parentId')) ; 
		
		
		
		$sort= GSMS::$class['input']->post('sort'); 
		switch ($sort) 
		{				 
			case 'last':$selectedSort  =5 ; break;
			case 'topView':$selectedSort  =3 ;break;
			case 'topJoin':$selectedSort  =1 ;break;				 
			case 'vip':
				$vip  =1 ; 
				break;				
			case 'topComment':$selectedSort  =4 ;break;
			case 'rate':$selectedSort  =2 ;break;
			case 'member':$selectedSort  =6 ;break;
			case 'my':
				$user = (intval(GSMS::$class['input']->post('user'))==0 ? 3 : GSMS::$class['input']->post('user')) ;
				$accept=1;					
				break;
			default:$selectedSort  =5 ;break;
		}
		
		$tempShajare = GSMS::$class['shajarename']->searchShajarename
			(	$begin,
				$end, 
				$user, //$user,
				'',//beginDate
				'',//endDate
				 
				GSMS::$class['input']->post('q'), //$title='',
				GSMS::$class['input']->post('desc'), //$describe='',
				GSMS::$class['input']->post('tag'), //$tag='',
				$accept,//accept
				'',//ownerMobile 
				intval($_POST['ostan']) ,
				intval($_POST['shahr']), 
				$vip,//vip
				$selectedSort,//sort 
				'',//$ownerId='', 
				'',//$ip ='',
				$parentId    
			);
			 
				 
				 
				 
			
			//-------------inserting ads-------------
			// GSMS::load("planRegistered", 'models');
			// $ads =  GSMS::$class['planRegistered']->getAdsGroup('view_in_site_main' , 5) ; 
			// $p =count($ads);
			// for($i=1;$i<$p;$i++)
			// {
				// array_unshift($tempGroups[0],$ads[$i]);	
			// }
		 
		 
		 echo (json_encode( $tempShajare));
			 
        
    }

    function uploadPicture($shajarename )
	{
		$this->checkToken();
		
		$iconId =0;
		if (isset($_FILES)) 
		{
			
			GSMS::load('visit','models');
		
			$data=  't:' . GSMS::$class['input']->post('for') . 
					',i:' . GSMS::$class['input']->post('item')  ;
					 
			GSMS::$class['visit']->log('mobileuploadPicture',$data,$this->user->id);
	 
			$fileName = $_FILES['uploaded_file']['name'];
			if (!file_exists(GSMS::$tempDir . $fileName)) 
			{

				if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], GSMS::$tempDir . $fileName)) 
				{
					GSMS::load("filesystem", "libs");
					
					$path = GSMS::$config['photo_archive_path']. DIRECTORY_SEPARATOR;					
					 
					
					$path .= 'en' . DIRECTORY_SEPARATOR .  $this->user->id . DIRECTORY_SEPARATOR;
					$pathDB  = 'en' . DIRECTORY_SEPARATOR . $this->user->id . DIRECTORY_SEPARATOR;
					
					if (!file_exists($path))
						mkdir($path, 0755);	
					
					$path .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
					$pathDB .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
					
					if (!file_exists($path))
						mkdir($path, 0755);
						
					$path .= 'images' . DIRECTORY_SEPARATOR;
					$pathDB .= 'images'  . DIRECTORY_SEPARATOR;
					
					if (!file_exists($path))
						mkdir($path, 0755);
					
					$new_fileName = GSMS::$class['filesystem']->sanitize($fileName,true,true);
				
					$new_path = $new_fileName;
					while(file_exists( $path .$new_path))
					{
						$new_path = rand() . $new_fileName ; 
					}
					
					$uploadFor="pic";
					$itemId=0;
					
					if (isset($_POST['for']))		
					{						
						$uploadFor=GSMS::$class['input']->post('for');
						$itemId=GSMS::$class['input']->post('item');
					}
					 
						
					 				
					
					$tempPicture =R::dispense('picture');
					$tempPicture->title = GSMS::$class['input']->post('title');
					$tempPicture->description = GSMS::$class['input']->post('description');
					$tempPicture->picturePath = $pathDB . $new_path.'.jpg';
					$tempPicture->createDate =date("Y-m-d H:i:s");
					$tempPicture->shajarenameId = $shajarename;
					
					//$tempPicture->userId = $user['UserID'];
					$tempPicture->itemId = $itemId;
					$tempPicture->itemType =$uploadFor;
					$iconId = R::store($tempPicture );
					rename(GSMS::$tempDir . $fileName,$path .$new_path.'.jpg');
					echo  $iconId ; 
					
				}
			}	
		
		
		}
					
	}
	
    function insert()
    {
		$this->checkToken();
		
		
		
		$json =stripslashes($json = GSMS::$class['input']->post('json')) ; 
		 
		if (strlen($json) < 10  )
		{
			echo json_encode(array('bad parameter')); 
			return ; 
		}			
	 	
	 	
		
		
		$data = json_decode($json,true) ; 
	 
		GSMS::load('visit','models');
		$data2= 'name:'. $data['info']["name"] . 
				 ',id:' . 	intval($data['info']["online_id"] ) . 
				 ',v:' . GSMS::$class['input']->post('v');
				 
				
		 GSMS::$class['visit']->log('mobileInsert',$data2,$this->user->id );
		 
		 
		GSMS::load("shajarename", 'models');
		GSMS::load('member', 'models');
		
		$shajarename = new shajarename();
		
		if (intval($data['info']["is_online"])>0 )   
		{
			$shajareID = intval($data['info']["is_online"]) > 1 ? intval($data['info']["is_online"]) : intval($data['info']["online_id"]); 
			$shajarename =$shajarename->getShajarename( $shajareID );

			if (! is_object($shajarename) )
			{
				echo json_encode(array('FamilyTree Not Found.')); 
				//block user 
				//try to edit 
				return ; 
			}
			
			if ($shajarename->userId != $this->user->id )
			{
				$this->user->is_block = intval($this->user->is_block) + 1; ; 
				$this->user->blockdesc = 
							$this->user->blockdesc 
							."\n [".GSMS::$class['calendar']->now().']'
							.' - try to edit another user data'; 
							
				$this->user->block_date=GSMS::$class['calendar']->now() ; 
				
				$this->user->save() ; 
				echo json_encode(array('Access Denied Error. We Block Danger Users.')); 
				return;
			}
			
			
		}
		
		

		
		
	
		if( $this->user->is_block > 0  ) 
		{
			$d_arr  = GSMS::$class['calendar']->getdate(strtotime(date("Y-m-d")."-2 days"));
			$expireDate  =  sprintf("%04d-%02d-%02d", $d_arr['year'], $d_arr['mon'], $d_arr['mday']);
			
			if($expireDate >= $this->user->block_date ) 
			{
				$this->user->is_block = 0 ; 
				$this->user->save() ; 
			}
			else
			{
				
				echo json_decode(array( "Your Account is Blocked . send email ot nasservb@gmail.com"));
				
				return ; 
			}
				
		}
			
		if( $this->user->is_block <= 0  ) 
		{
			//edit
			if ($shajarename->id > 0 ) 
			{
				$member = new member(); 
				$member->deleteMemberByShajarename($shajarename->id);
			}
			
			$shajarename->title =$data['info']["name"];
			$shajarename->description =$data['info']["description"];
			$shajarename->createDate =$data['info']["create_date"];
			
			$shajarename->storeCount =count($data['store'] );
			$shajarename->memberCount =count($data['members'] );
			$shajarename->picCount =count($data['photo'] );
			$shajarename->commentCount =0;
			$shajarename->userId =$this->user->id ;
			
			$shajarename->parentShajarenameId =$data['info']["version_id"];
			//get parent name from id 			
			// update parent child count 
			if (intval($data['info']["version_id"])>0 )
			{
				$shajare = new shajarename();	 
		
				$parentShajare=$shajare->getShajarename(intval($data['info']["version_id"]));
				if(is_object($parentShajare))
				{
					$parentShajare->childCount = $parentShajare->childCount+1;
					$parentShajare->save();
				}
		
			}
			
			$shajarename->ownerId =$data['info']["owner_id"];
			$shajarename->ownerName =$data['info']["owner_name"];
			
			
			$shajarename->rootNodeIndex =$data['info']["root_node_index"];
			//get rootNodeName from id 
			
			
			$shajarename->shahrId =$data['info']["shahr_id"];			
			//get ostan from shahr 
			//$shajarename->ostanId =$data['info']["shahr_id"];
			
			
			$shajarename->softversion =GSMS::$class['input']->post('v');			
		

			$shajarename->isAccepted = 1;
			$shajarename->calcRate = 0;
			$shajarename->isPublic = 1;
			$shajarename->isDeleted = 0;
			
			$shajarename->createDate = date("Y-m-d");
		 
			$shajarename->save();
			

			/************member************/
			
			for ($i =0 ;$i<count($data['members']);$i++)
			{
				$member =new member(); 
				
				$member->name=$data['members'][$i]["Name"];
				$member->family=$data['members'][$i]["Family"];
				$member->birthdate=$data['members'][$i]["BirthDay"];
				$member->userId=$this->user->id;
				$member->isMale=$data['members'][$i]["IsMale"];
				$member->isDied=$data['members'][$i]["IsDied"];
			
				$member->phoneNumber="";
				//$member->photos=$data['members'][$i][""];
				
				$member->partners=implode("," , $data['members'][$i]["Partners"]);
				
				$member->fatherId=$data['members'][$i]["Father"];
				$member->motherId=$data['members'][$i]["Mother"];
				
				$member->childs=implode("," , $data['members'][$i]["Childs"]);
				$member->level=$data['members'][$i]["Level"];
				$member->describtion=$data['members'][$i]["Description"];
				$member->index=$data['members'][$i]["Index"];
				$member->shajarenameId= $shajarename->id;
				$member->diedDate=$data['members'][$i]["DiedDate"]; 
				$member->save();
			}

			/************geraph************/
			
			$geraph = R::dispense('geraph');
			$geraph->shajarenameId=$shajarename->id;
			$geraph->createDate=date("Y-m-d");
			$geraph->userId=$this->user->id ;
			$geraph->ip=GSMS::$class['input']->ip_address();
			$geraph->geraphDate=$data['geraphData'] ;
			R::store( $geraph );
			
			/************store************/
			
			GSMS::load("comment", 'models');
			for ($i =0 ;$i<count($data['store']);$i++)
			{
				$comment =new comment(); 
				$comment->memberIndex=$data['store'][$i]["member_id"]; 
				$comment->content=$data['store'][$i]["content"]; 
				$comment->createDate=$data['store'][$i]["time"]; 
				 
				$comment->itemType='store'; 
				$comment->itemId=$data['store'][$i]["id"]; 
				
				$comment->accepted=1; 
				$comment->userId=$this->user->id; 
				$comment->shajarenameId=$shajarename->id; 
				$comment->save();
				
			}
			/************pics************/
			
			GSMS::load("picture", 'models');
			for ($i =0 ;$i<count($data['photo']);$i++)
			{
				$picture =new picture(); 
				$picture->memberIndex=$data['photo'][$i]["member_id"]; 				 
				  
				$picture->itemType='photo'; 
				$picture->itemId=$data['photo'][$i]["id"]; 
			 
				$picture->accepted=1; 
				$picture->userId=$this->user->id; 
				$picture->shajarenameId=$shajarename->id; 
				$picture->save();
				
			}
			
			
			echo json_encode(array($shajarename->id) ) ;	
			return 	; 
		}
		
		
		 
    }

	function getShajarename($id=0,$details=1)
	{
		$this->checkToken();
		
		if ($id <= 0 )
		{
			echo( json_encode(array(101,'bad parameter')));
			return ; 
		} 
	
		GSMS::load('visit','models');
		
		$data=  
				'id:' . 	id . 
				',v:' . 	GSMS::$class['input']->post('v');
				
		GSMS::$class['visit']->log('mobilegetShajarename',$data,$this->user->id);
		
		$data =array() ; 
		
		GSMS::load('shajarename', 'models');
		$shajarename = new shajarename();	
		$data[0]=$shajarename->getShajarename($id);
		
		if ($details == 1 )
		{
			/*********member*****/ 	
			GSMS::load('member', 'models');
			$member = new member();				 
			$temp  = $member->listMemberByShajarename($id,0,$data[0]->memberCount);			
			$data[1] = $temp[0];
			
			/*********comment*****/ 	
			GSMS::load('comment', 'models');
			$comment = new comment();				 
			$temp1  = $comment->listCommentByShajarename($id);			
			$data[2] = $temp1[0];
			
			/*********store*****/ 				 
			$temp2  = $comment->listStoreByShajarename($id);			
			$data[3] = $temp2[0];
			
			/*********pic*****/ 
			GSMS::load('picture', 'models');
			$picture = new picture();			
			$temp3  = $picture->listPictureByShajarename($id);			
			$data[4] = $temp3[0];
		 
		}
		
		echo (json_encode( $data));
			
			 
         
	}
	
	function insertComment($itemId=0)
	{
		$this->checkToken();
		
		GSMS::load('visit','models');
		GSMS::$class['visit']->log('mobileInsertComment','itemId='.$itemId,$this->user->id);
		
		
		
		GSMS::load('shajarename','models');
		 		
		GSMS::load('comment','models');
		$tempComment = new comment();
		
		$tempComment->name=GSMS::$class['input']->post('name');
		
		$tempComment->shajarenameId= GSMS::$class['input']->post('shajarenameId');
		$tempComment->memberIndex= GSMS::$class['input']->post('memberIndex');
		
		$tempComment->email= GSMS::$class['input']->post('mobile');
		
		$tempComment->photos= GSMS::$class['input']->post('pic');
		
		$tempComment->content= GSMS::$class['input']->post('text');
		
		$tempComment->createDate= date("Y-m-d H:i:s");
		
		$type = GSMS::$class['input']->post('type'); 
		
		
		
		$shajarename = new shajarename();	 
		
		$inf=$shajarename->getShajarename(GSMS::$class['input']->post('shajarenameId'));
		
		if ($type == 'store' )
		{			
			$inf->storeCount =intval($inf->storeCount)+1;
		}
		else if ($type == 'pic' ) 
		{			
			$inf->picCount =intval($inf->picCount)+1;		
		}
		else if ($type == 'shajarename' ) 
		{
			$inf->commentCount =intval($inf->commentCount)+1;
		}
		
		$inf->save();
		
		$tempComment->itemId=  $itemId;

		$tempComment->softversion= intval(GSMS::$class['input']->post('v'));
		$tempComment->userId= GSMS::$class['input']->post('user'); 
		
		$tempComment->itemType=GSMS::$class['input']->post('type');
		  
		$tempComment->save();
		
		echo( json_encode(array($tempComment)));
		 
	}
		 
    public function getComments($itemId)
	{
		$this->checkToken();
		
		GSMS::load('telgroup','models');
		GSMS::load('comment','models');
		
		$user = GSMS::$class['input']->post('user');
		
		GSMS::load('visit','models');
		
		GSMS::$class['visit']->log('mobileGetComments','itemId='.$itemId,$this->user->id );
		
		 
		$inf=array(); 
		
		if(intval($itemId)>0 )
		{
			
		
			$inf= GSMS::$class['comment']->searchComment(
					'',//$Name='',
					'',//$BeginCreateDate='',
					'',//$EndCreateDate='',
					$itemId,//=0,
					'',//$ItemType='', 
					'',//$Content='',
					0,//$UserId=0,
					0,//$begin=0,
					30,//$end=0,
					0  //$accepted=0
					);
		}
		else 
		{
			$inf= GSMS::$class['comment']->searchComment(
					'',//$Name='',
					'',//$BeginCreateDate='',
					'',//$EndCreateDate='',
					0,//$itemId,
					'notic',//$ItemType='', 
					'',//$Content='',
					$user,//$UserId=0,
					0,//$begin=0,
					30,//$end=0,
					-1,//$accepted=0,
					0
					);
			for($i=0;$i<count($inf[0]);$i++)		
			{
				$inf[0][$i]->readed=1;
				$inf[0][$i]->save();					
			}
		}
			
			
		echo json_encode($inf);
	 
	}

	public function register()
	{
		
		 GSMS::load('visit','models');
		 GSMS::$class['visit']->log('mobileRegister',
						'dev:'.GSMS::$class['input']->post('phone').
						',v:'.GSMS::$class['input']->post('v').
						',m:'.GSMS::$class['input']->post('model'));
		
		
		if(isset($_POST['pass']) && $_POST['pass'] == '1266')
		{
			GSMS::load('admin','models');
			
			$pass= rand(20,80000);
			
			if (intval(GSMS::$class['input']->post('phone'))>5)
			{
				//exit('access denied emulator');
				//return;
			}		
			$tempAdmin2 =GSMS::$class['admin']->getAdminByPhone(GSMS::$class['input']->post('phone'));
			
			if(is_object( $tempAdmin2) && intval(GSMS::$class['input']->post('phone'))>5  )   //&& $tempAdmin2->model == GSMS::$class['input']->post('model')
			{
				$tempAdmin2->password=$pass;
				$tempAdmin2->line=GSMS::$class['session']->encode($pass);
				$tempAdmin2->softversion=GSMS::$class['input']->post('v');
				$tempAdmin2->describe = $tempAdmin2->describe . ','. GSMS::$class['input']->post('v');
				
				$tempAdmin2->save();
				
				
				
				$tempAdmin2->password=$pass;
				$tempAdmin2->line=GSMS::$class['session']->encode($pass);
				
				echo json_encode(array($tempAdmin2));
				
				return;
			}
			
					
			
			$tempAdmin=new admin();
			$tempAdmin->name='';
			

			$tempAdmin->is_block=-1;
			$tempAdmin->mobile='09111111111';
			$tempAdmin->mail='';
			
			
					
			$tempAdmin->password=$pass;
			$tempAdmin->line=GSMS::$class['session']->encode($pass);
			
			$tempAdmin->adminType=2;
			$tempAdmin->describe='version:'. GSMS::$class['input']->post('v');
			
			$tempAdmin->sdk		=GSMS::$class['input']->post('sdk');
			$tempAdmin->model	=GSMS::$class['input']->post('model');
			 
			$tempAdmin->phone	=GSMS::$class['input']->post('phone');
			$tempAdmin->softversion=GSMS::$class['input']->post('v');
									
			$tempAdmin->save();
			
			$tempAdmin2 =new admin();
			
			$tempAdmin2->id =$tempAdmin->id;
			$tempAdmin2->password=$pass;
			$tempAdmin2->name='ثبت نام با موفقیت انجام شد ';
			$tempAdmin2->family='تبریک';
			$tempAdmin2->line=GSMS::$class['session']->encode($pass);
			
			echo json_encode(array($tempAdmin2));
			return ;
		}
	}
	
	public function registerProduct() 
	{
		$this->checkToken();
		
		
		$plan = GSMS::$class['input']->post('plan'); 
		
		GSMS::load('visit','models');
		GSMS::$class['visit']->log('mobileregisterProduct',$plan ,$this->user->id);
		
		GSMS::load('itransaction','models');
		$tempTransaction = new itransaction(); 
		
		//$tempTransaction->resNum      = $this->resNum;
		//$tempTransaction->refNum      = $this->refNum;
		
		
		if ($plan == 'monthly_subscribe') 
		{
			$tempTransaction->totalAmount =1000;
		}
		else if ($plan == 'yearly_subscribe') 
		{
			$tempTransaction->totalAmount =5000;
		}
		
		//$tempTransaction->payment     = $this->payment;
		//$tempTransaction->dateStart   = $this->dateStart;
		$tempTransaction->lastUrl     = GSMS::$class['input']->post('line');
		
		$tempTransaction->timeStart   = GSMS::$class['input']->post('time');
		//$tempTransaction->email       = $this->email;
		$tempTransaction->adminId     = $this->user->id ;
		//$tempTransaction->name        = $this->name;
		//$tempTransaction->phone       = $this->phone;
		$tempTransaction->comment     = 'user:'. GSMS::$class['input']->post('user'); 
		//$tempTransaction->tempCredit  = $this->tempCredit;
		$tempTransaction->planId      = GSMS::$class['input']->post('plan');
		$tempTransaction->payload      = GSMS::$class['input']->post('payload');
		$tempTransaction->version      = GSMS::$class['input']->post('v');
		$tempTransaction->save();
		 
	} 
	 
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}