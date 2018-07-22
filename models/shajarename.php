<?php //allahoma sale ala mohammad va ale mohammad 
class shajarename
{
	public $id;
	public $title;
	public $description;
	public $coverPictureId;
	public $iconPictureId;
	public $insertDate;
	public $createDate;
	public $userId;
	public $ownerName;
	public $ownerId;
	public $isPublic;
	public $viewCount;
	public $likeCount;
	public $commentCount;
	public $isDeleted;
	public $calcRate;
	public $isAccepted;
	public $memberCount;
	public $shahrId;
	public $ostanId;
	public $isVIP;
	public $tag;
	public $ip;
	public $softversion;
	public $parentShajarenameId;
	public $parentName;
	public $rootNodeIndex;
	public $rootNodeName;		
	public $childCount;
	public $members;
	public $storeCount;
	public $picCount;
	
	public function __construct()
	{
		GSMS::load('log', 'models');
		
		$user             = GSMS::$class['session']->getUser();
		$this->id         = 0;
		$this->insertDate = GSMS::$class['calendar']->now();
		$this->createDate = GSMS::$class['calendar']->now();
		$this->userId     = ($user['UserID']);
		GSMS::$class['system_log']->log('DEBUG', 'shajarename class Initialized');
	} //fun
	
	function __set($propertyName, $propertyValue)
	{
		$this->propertyName = $propertyValue;
	} //fun
	
	public function save()
	{
		$ip        = GSMS::$class['input']->ip_address();
		$tempShajarename = R::dispense('shajarename');
		if ($this->id != 0)
		{
			$tempShajarename             = R::load('shajarename', $this->id);
			$tempShajarename->isAccepted = $this->isAccepted;
		} //$this->id != 0
		else
		{
			GSMS::load('admin', 'models');
			$admin = GSMS::$class['admin']->getAdmin($this->userId);

			$check = $this->title.' ' . $this->description.' ' .$this->tag;
			
			if ((strpos($check , 'سکس') !== false) ||
				 (strpos(trim(strtolower($check )), 'sex') !== false) ||  
				 (strpos($check , 'کس ننه') !== false) ||    
				 (strpos($check , 'xxx') !== false) || 
				 (strpos($check , 'شهوت') !== false) || 
				 (strpos($check , ' کوس ') !== false) ||
				 (strpos($check , 'جنده') !== false) ||
				 (strpos($check , ' ناف ') !== false) ||
				 (strpos($check , 'کير') !== false) ||
				 (strpos($check , 'كير') !== false) ||
				 (strpos($check , 'کون') !== false) ||
				 (strpos($check , 'پورن') !== false) || 
				 (strpos($check , 'س ک س') !== false) ||
				 (strpos($check , 'gay') !== false) ||  
				 (strpos($check , ' کص ') !== false) ||  
				 (strpos($check , 'کاندوم') !== false) ||
				 (strpos($check , 'کیر') !== false) ||
				 (strpos($check , 'ممه') !== false) || 
				 (strpos($check , 'س.ک.س') !== false) ||
				 (strpos($check , 'حشری') !== false) || 
				 (strpos($check , 'گوز') !== false) ||
				 (strpos($check , 'سیکتیر') !== false) ||
				 (strpos($check , 'فیلم سوپر') !== false) ||
				 (strpos($check , 'لاشی') !== false) ||
				 (strpos($check , 'داغ') !== false) ||     
				 (strpos($check , 'جق') !== false))
			{
				$admin->is_block   = intval($admin->is_block) + 1;
				$admin->block_date = GSMS::$class['calendar']->now();
				$admin->blockdesc  = "متاسفانه مجبور شدیم دسترسی شما را به دلیل ثبت گروه زیر به مدت 48 ساعت از تاریخ : " . $admin->block_date . " ببندیم .\n" . $this->title . "\n" . $this->description;
				$admin->save();
				$tempShajarename->isAccepted = 0;
				$tempShajarename->isDeleted  = 5;
			} 			
			elseif ($admin->is_block == -1)
			{
				$tempShajarename->isAccepted = -1;
				$tempShajarename->isDeleted  = 0;
				$tempShajarename->isPublic   = -1;
			} //$admin->is_block == -1
			else
			{
				$q_count      = R::dispense('shajarename');
				$q_count      = R::getAll('select count(*)as cnt from  `shajarename` where  insert_date=\'' . $this->insertDate . '\' and  user_id =\'' . $this->userId . '\' ');
				$result_count = intval($q_count[0]['cnt']);
				if (($result_count > 6))
				{
					$tempShajarename->isAccepted = 0;
					$tempShajarename->isDeleted  = 3;
					$tempShajarename->isPublic   = 0;
				} //($result_count > 6)
				else
				{
					$tempShajarename->isAccepted = 1;
					$tempShajarename->isDeleted  = 0;
					$tempShajarename->isPublic   = 14;
				}
			}
		}
		
		$tempShajarename->title          = $this->title;
		$tempShajarename->description    = $this->description;
		$tempShajarename->coverPictureId = $this->coverPictureId;
		$tempShajarename->iconPictureId  = $this->iconPictureId;
		$tempShajarename->insertDate     = $this->insertDate;
		$tempShajarename->createDate     = $this->createDate;
		if ($this->id == 0)
			$tempShajarename->userId = $this->userId;
		$tempShajarename->ownerId             = $this->ownerId;
		$tempShajarename->ownerName           = $this->ownerName;
		$tempShajarename->viewCount           = intval($this->viewCount);
		$tempShajarename->likeCount           = intval($this->likeCount);
		$tempShajarename->commentCount        = intval($this->commentCount);
		$tempShajarename->calcRate            = intval($this->calcRate);
		$tempShajarename->memberCount         = intval($this->memberCount);
		$tempShajarename->shahrId             = intval($this->shahrId);
		$tempShajarename->ostanId             = intval($this->ostanId);
		$tempShajarename->isVIP               = intval($this->isVIP);		$tempShajarename->childCount               = intval($this->childCount);
		$tempShajarename->tag                 = $this->tag;
		$tempShajarename->softversion         = $this->softversion;
		$tempShajarename->parentShajarenameId = $this->parentShajarenameId;
		$tempShajarename->parentName		  = $this->parentName;
		$tempShajarename->rootNodeIndex         = $this->rootNodeIndex;
		$tempShajarename->rootNodeName        	= $this->rootNodeName;
		
		$tempShajarename->childCount         	= $this->childCount;
		$tempShajarename->members          		= $this->members;
		$tempShajarename->storeCount          	= $this->storeCount;
		$tempShajarename->picCount         		= $this->picCount;
		 
		$tempShajarename->ip                  = (($this->id != 0) ? $this->ip : $ip);
		$this->id                             = R::store($tempShajarename);
	} //func
	
	public function is_own($Id, $userId = 0)
	{
		if ($userId == 0)
		{
			$user   = GSMS::$class['session']->getUser();
			$userId = ($user['UserID']);
		} //$userId == 0
		$shajarename = $this->getShajarename($Id);
		if ($shajarename->id != $Id || $shajarename->userId != $userId)
		{
			return false;
		} //$shajarename->id != $Id || $shajarename->userId != $userId
		return true;
	}
	
	public function listShajarename($begin = 0, $end = 0)
	{
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		$result_c        = R::getAll('select count(*) as cnt from shajarename where is_accepted = 1 ');
		$result_count    = $result_c[0]['cnt'];
		$result          = R::dispense('shajarename');
		$result          = R::getAll('select  * from   `shajarename`  where is_accepted = 1  order by id desc

							limit ' . $begin . ',' . $end);
		$tempShajarename = $this->map($result);
		if (count($tempShajarename) > 0)
		{
			return array(
				$tempShajarename,
				$begin,
				$result_count
			);
		} //count($tempShajarename) > 0
		else
		{
			return array();
		} //else
	} //func
	
	public function getShajarename($id  )
	{
		$id = intval($id);
		if ($id > 0)
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('select *  from  `shajarename` where id =' . $id, 'shajarename.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'getShajarename ' //sql code subject	
				);
			$tempShajarenames = array();
			if ($max == 0)
				return array();
			else
			{
				$tempShajarenames = $this->map(array(
					$row
				));
				
			}
			return $tempShajarenames[0];
		} //if
		return array();
	} //func
	
	public function isShajarenameExsist($address = '', $adminId = '')
	{
		$shajarename = $this->getShajarename($Id);
		if ($shajarename->id)
		{
			return true;
		} //$shajarename->id
		return false;
	}
	
	public function listShajarenameByShahr($shahr_id, $begin = 0, $end = 0)
	{
		return $this->searchShajarename($begin, $end, 0, //user
			0, //beginDate
			0, //endDate
			0, //cat
			'', //$Title='',
			'', //$Description='',
			'', //$Tag='',
			1, //accept
			'', //ownerName
			'', //telegramAddress
			0, //ostan
			$shahr_id);
	}
	
	public function listShajarenameByOstan($ostan, $begin = 0, $end = 0)
	{
		return $this->searchShajarename($begin, $end, 0, //user
			0, //beginDate
			0, //endDate
			0, //cat
			'', //$Title='',
			'', //$Description='',
			'', //$Tag='',
			1, '', //ownerName
			'', //telegramAddress
			$ostan);
	}
	
	 
	public function listShajarenameByUser($user, $accepted, $begin = 0, $end = 0)
	{
		return $this->searchShajarename($begin, $end, $user, '', //$BeginCreateDate='',
			'', //$EndCreateDate=
			0, //$telgroupCategoryId=0,
			'', //$Title='',
			'', //$Description='',
			'', //$Tag='',
			$accepted);
	}
	
	public function searchShajarename($begin = 0, $end = 0, $UserId = 0, $BeginCreateDate = '', $EndCreateDate = '', $Title = '', $Description = '', $Tag = '', $isAccepted = 1, $ownerName = '', $ostan = 0, $shahr = 0, $VIP = -1, $sortBy = 5, //[1=>likeCount,2=>rate,3=>viewCount,4=>commentCount,5=>date_newest,]
		$ownerId = '', $ip = '', $parentId = 0, $includeMember = 0)
	{
		$row = '';
		$max = 0;
		if ($begin < 0)
			$begin = 0;
		if ($BeginCreateDate != '')
			$EndCreateDate = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		if ($end > GSMS::$config['page_item_per_page'])
			$end = $end - $begin;
		$q = ($Title == '' ? '' : '`title` like \'%' . $Title . '%\'  ');
		$q .= ($BeginCreateDate == '' ? '' : ($q != '' ? ' and ' : '') . '`insert_date` >=   \'' . $BeginCreateDate . '\'  and `insert_date` <= \'' . $EndCreateDate . '\'');
		$q .= ($Description == '' ? '' : ($q != '' ? ' and ' : '') . '`description` like \'%' . $Description . '%\'   ');
		$q .= ($Tag == '' ? '' : ($q != '' ? ' and ' : '') . '`tag` like \'%' . $Tag . '%\'   ');
		$q .= ($UserId == 0 ? '' : ($q != '' ? ' and ' : '') . '`user_id`=' . $UserId . '   ');
		if ($isAccepted == 14) //اولین بار گروه درج کرده اند 
		{
			$q .= (($q != '' ? ' and ' : '') . '`is_accepted`=0 and  `is_public` =14   ');
		} //$isAccepted == 14
		else
		{
			$q .= ($isAccepted == -1 ? '' : ($q != '' ? ' and ' : '') . '`is_accepted`=' . $isAccepted . '   ');
		}
		if ($VIP == 1) //رسمی
		{
			$q .= ($q != '' ? ' and  ' : '') . ' ( `is_super`=' . $isSuperGroup . '  or   ' . '`is_vip`=' . $VIP . ' )  ';
		} //$VIP == 1
		else
		{
			$q .= ($VIP == -1 ? '' : ($q != '' ? ' and ' : '') . ' `is_vip`=' . $VIP . ' ');
		}
		$q .= ($ownerName == '' ? '' : ($q != '' ? ' and ' : '') . '`owner_name`=\'' . $ownerName . '\'   ');
		$q .= ($ownerId == '' ? '' : ($q != '' ? ' and ' : '') . '`ownerId`=\'' . $ownerId . '\'   ');
		$q .= ($ip == '' ? '' : ($q != '' ? ' and ' : '') . '`ip`=\'' . $ip . '\'   ');
		$q .= ($parentId == 0 ? '' : ($q != '' ? ' and ' : '') . '`parent_shajarename_id`=\'' . $parentId . '\'   ');
		
		$q .= ($ostan == 0 ? '' : ($q != '' ? ' and ' : '') . '`ostan_id`=\'' . $ostan . '\'   ');
		$q .= ($shahr == 0 ? '' : ($q != '' ? ' and ' : '') . '`shahr_id`=\'' . $shahr . '\'   ');
		if ($q != '')
			$q = ' where ' . $q;
		
		/*-----------remove paging for beter performance 
		GSMS::$class['DB']->run('select count(*)as cnt from  `shajarename` ' . $q, 'shajarename.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'shajarename count' //sql code subject	
			);
				$result_count = $row['cnt'];
			*/
			
		$result_count = 100;
		
		switch ($sortBy)
		{ //						[1=>likeCount,2=>rate,3=>viewCount,4=>commentCount,5=>date_newest,]
			case 0:
				//unsort
				break;
			case 1:
				$q .= ' order by like_count desc ';
				break;
			case 2:
				$q .= ' order by calc_rate desc ';
				break;
			case 3:
				$q .= ' order by view_count desc ';
				break;
			case 4:
				$q .= ' order by comment_count desc ';
				break;
			case 5:
				$q .= ' order by id desc ';
				break;
			case 6:
				$q .= ' order by  member_count desc ';
				break;
			case 7:
				$q .= ' order by  child_count desc ';
				break;
		} //$sortBy
		$_SESSION['query_count'] = $result_count;
		$_SESSION['query']       = 'select * from `shajarename`  ' . $q;
		$row                     = '';
		$max                     = 0;
		
		$tempShajarenameRows     = GSMS::$class['DB']->run('select *  from  `shajarename` ' . $q . ' limit ' . $begin . ',' . $end, 'shajarename.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'searchShajarename ' //sql code subject	
			);
		if ($max == 0)
			return array(
				array(),
				$begin,
				0
			);
		else
		{
			$data = $this->map($tempShajarenameRows);
			if ($includeMember == 1)
			{
				GSMS::load('member', 'models');
				$member = new member();
				for ($i = 0; $i < count($data); $i++)
				{
					$temp              = $member->listMemberByShajarename($data[$i]->id);
					$data[$i]->members = $temp[0];
				} //$i = 0; $i < count($data); $i++
			} //$includeMember == 1
			return array(
				$data,
				$begin,
				$result_count
			);
		}
	} //func
	public function review($sql, $result_count, $begin = 0, $end = 30)
	{
		if ($end > GSMS::$config['page_item_per_page'])
			$end = $end - $begin;
		$tempShajarenames    = R::dispense('shajarename');
		$tempShajarenameRows = R::getAll($sql . ' limit ' . $begin . ',' . $end);
		$tempShajarenames    = $this->map($tempShajarenameRows);
		return array(
			$tempShajarenames,
			$begin,
			$result_count
		);
	}
	public function toString($id = 0)
	{
		if ($id == 0)
		{
			return $this->title;
		} //$id == 0
		else
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('select `title` from  `shajarename` where `id`=' . $id, 'shajarename.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'select toString for telgroup' //sql code subject	
				);
			if ($max == 1)
			{
				return $row['title'];
			} //$max == 1
			else
			{
				return 404;
			} //else
		} //else
	} //func
	public function getCount()
	{
		$row = '';
		$max = 0;
		GSMS::$class['DB']->run('select count(`id`)as cnt from  `shajarename` where is_accepted =1', 'shajarename.php', $row, $max, 'select Count of shajarename');
		return $row['cnt'];
	} //func
	public function map($row)
	{
		$tempShajarenames = array();
		$count            = count($row);
		for ($i = 0; $i < $count; $i++)
		{
			$tempShajarename                      = new shajarename();
			$tempShajarename->id                  = $row[$i]['id'];
			$tempShajarename->title               = $row[$i]['title'] ?: '';
			$tempShajarename->description         = $row[$i]['description'] ?: '';
			$tempShajarename->coverPictureId      = $row[$i]['cover_picture_id'] ?: 0;
			$tempShajarename->iconPictureId       = $row[$i]['icon_picture_id'] ?: 0;
			$tempShajarename->insertDate          = $row[$i]['insert_date'] ?: '';
			$tempShajarename->createDate          = $row[$i]['create_date'] ?: '';
			$tempShajarename->userId              = $row[$i]['user_id'] ?: 0;
			$tempShajarename->ownerName           = $row[$i]['owner_name'] ?: '';
			$tempShajarename->ownerId             = $row[$i]['ownerId'] ?: '';
			$tempShajarename->isPublic            = $row[$i]['is_public'] ?: 0;
			$tempShajarename->viewCount           = $row[$i]['view_count'] ?: 0;
			$tempShajarename->likeCount           = $row[$i]['like_count'] ?: 0;
			$tempShajarename->commentCount        = $row[$i]['comment_count'] ?: 0;
			$tempShajarename->isDeleted           = $row[$i]['is_deleted'] ?: 0;
			$tempShajarename->calcRate            = $row[$i]['calc_rate'] ?: 0;
			$tempShajarename->isAccepted          = $row[$i]['is_accepted'] ?: 0;
			$tempShajarename->memberCount         = $row[$i]['member_count'] ?: 0;
			$tempShajarename->shahrId             = $row[$i]['shahr_id'] ?: 0;
			$tempShajarename->ostanId             = $row[$i]['ostan_id'] ?: 0 ;
			$tempShajarename->isVIP               = $row[$i]['is_vip'] ?: 0 ;
			$tempShajarename->tag                 = $row[$i]['tag'] ?: '';
			$tempShajarename->ip                  = $row[$i]['ip'] ?: '';
			$tempShajarename->parentShajarenameId = $row[$i]['parent_shajarename_id'] ?: 0;
			$tempShajarename->parentName 		  = $row[$i]['parent_name'] ?: '';
			$tempShajarename->rootNodeIndex          = $row[$i]['root_node_index'] ?: '';
			$tempShajarename->rootNodeName        = $row[$i]['root_node_name'] ?: 0;
			$tempShajarename->storeCount          = $row[$i]['store_count'] ?: 0;
			$tempShajarename->picCount            = $row[$i]['pic_count'] ?: 0;						$tempShajarename->childCount            = $row[$i]['child_count'] ?: 0;
			$tempShajarenames[]                   = $tempShajarename;
		} //$i = 0; $i < $count; $i++
		return $tempShajarenames;
	}
} //class
if (!defined("GSMS"))
{
	exit("Access denied");
} //!defined("GSMS")

