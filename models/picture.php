<?php 

//allahoma sale ala mohammad va ale mohammad 



class picture
{
	public $Id;
	public $Title;
	public $CreateDate;
	public $PicturePath;
	public $Description;
	public $UserId;
	public $ItemId;
	public $ItemType;
	public $ViewCount;
	public $LikeCount;
	public $MemberIndex;
	public $ShajarenameId;
	public $Accepted;
	public function __construct()
	{
		GSMS::load('log', 'models');
		$this->id         = 0;
		$this->Accepted   = 0;
		$this->CreateDate = GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG', 'picture class Initialized');
	} //fun
	function __set($propertyName, $propertyValue)
	{
		$this->propertyName = $propertyValue;
	} //fun
	public function save()
	{
		$user = GSMS::$class['session']->getUser();
		if ($this->id == 0)
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('INSERT INTO `picture` 

							(

								`id` ,

								`title` ,

								`description` ,

								`picture_path`,

								`create_date`,

								`item_id`,

								`item_type`,

								`user_id`,

								`view_count`,

								`accepted`,

								`like_count`

							)

							VALUES 

							(

								NULL ,  

								\'' . $this->Title . '\', 

								\'' . $this->Description . '\',  

								\'' . $this->PicturePath . '\',  

								\'' . $this->CreateDate . '\',

								\'' . $this->ItemId . '\',

								\'' . $this->ItemType . '\',

								\'' . ($user['user_id']) . '\',

								\'' . $this->ViewCount . '\',

								\'' . $this->Accepted . '\',

								\'' . $this->LikeCount . '\'

								)', 'picture.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'insert picture' //sql code subject	
				);
			return 1;
		} //$this->id == 0
		else
		{
			//write code for delete last picture
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('UPDATE `picture`

							SET 

								`title`=\'' . $this->Title . '\', 

								`description` =\'' . $this->Description . '\', 

								`picture_path`=\'' . $this->PicturePath . '\', 

								`create_date`=\'' . $this->CreateDate . '\', 

								`item_id`=\'' . $this->ItemId . '\', 

								`item_type`=\'' . $this->ItemType . '\', 

								`user_id`=\'' . $user['user_id'] . '\', 

								`view_count`=\'' . $this->ViewCount . '\' ,

								`like_count`=\'' . $this->LikeCount . '\' 

							WHERE `id` =' . $this->Id, 'picture.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'update picture' //sql code subject	
				);
			return 1;
		} //else
	} //func
	// you not able to see someone who have not your child!
	public function listPictures($begin = 0, $end = 0)
	{
		$user = GSMS::$class['session']->getUser();
		$row  = '';
		$max  = 0;
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		$query        = GSMS::$class['DB']->run('select * from `picture` 

								', //WHERE `parent_id`='.$user['user_id'],
			'picture.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'list picture' //sql code subject	
			);
		$tempPictures = array();
		if ($max > 0)
		{
			for ($i = 0; $i < $max; $i++)
			{
				$tempPicture                = new picture();
				$row                        = $query[$i];
				$tempPicture->Id            = $row['id'];
				$tempPicture->Title         = $row['title'] ?: '';
				$tempPicture->PicturePath   = $row['picture_path'] ?: '';
				$tempPicture->UserId        = $row['user_id'] ?: 0;
				$tempPicture->CreateDate    = $row['create_date'] ?: '';
				$tempPicture->ItemId        = $row['item_id'] ?: 0;
				$tempPicture->ItemType      = $row['item_type'] ?: '';
				$tempPicture->Description   = $row['description'] ?: '';
				$tempPicture->ViewCount     = $row['view_count'] ?: 0;
				$tempPicture->LikeCount     = $row['like_count'] ?: 0;
				$tempPicture->MemberIndex   = $row['member_index'] ?: '';
				$tempPicture->ShajarenameId = $row['shajarename_id'] ?: 0;
				$tempPictures[$i]           = $tempPicture;
			} //for
			return $tempPictures;
		} //$max > 0
		else
		{
			return 404; // no result for query
		} //else
	} //func
	public function getPicture($id)
	{
		$id = intval($id);
		if ($id > 0)
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('select * from `picture` where `id`=' . $id, 'picture.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'select requested picture' //sql code subject	
				);
			if ($max == 1)
			{
				$tempPicture                = new picture();
				$tempPicture->Id            = $row['id'];
				$tempPicture->Title         = $row['title'] ?: '';
				$tempPicture->PicturePath   = $row['picture_path'] ?: '';
				$tempPicture->UserId        = $row['user_id'] ?: 0;
				$tempPicture->CreateDate    = $row['create_date'] ?: '';
				$tempPicture->ItemId        = $row['item_id'] ?: 0;
				$tempPicture->ItemType      = $row['item_type'] ?: '';
				$tempPicture->Description   = $row['description'] ?: '';
				$tempPicture->ViewCount     = $row['view_count'] ?: 0;
				$tempPicture->LikeCount     = $row['like_count'] ?: 0;
				$tempPicture->MemberIndex   = $row['member_index'] ?: '';
				$tempPicture->ShajarenameId = $row['shajarename_id'] ?: 0;
				return $tempPicture;
			} //$max == 1
		} //if
		return 0;
	} //func
	public function deletePicture($id)
	{
		$id = intval($id);
		if ($id > 0)
		{
			$row  = '';
			$max  = 0;
			$p    = $this->getPicture($id);
			$path = GSMS::$config['photo_archive_path'] . $p->PicturePath;
			@unlink($path);
			GSMS::$class['DB']->run('delete   from `Picture` where `id`=' . $id, 'Picture.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'select requested Picture' //sql code subject	
				);
			return 1;
		} //if
	} //func
	public function deleteTempPictures()
	{
		$user = GSMS::$class['session']->getUser();
		if (intval($user['UserID']))
		{
			$tempPic = $this->searchPictures('#', '', '', 0, '', '#', $user['UserID']);
			for ($i = 0; $i < count($tempPic[0]); $i++)
			{
				$this->deletePicture($tempPic[0][$i]->id);
			} //$i = 0; $i < count($tempPic[0]); $i++
		} //intval($user['UserID'])
	}
	public function listTempPictures($begin = 0, $end = 0)
	{
		$user = GSMS::$class['session']->getUser();
		$row  = '';
		$max  = 0;
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		$query        = GSMS::$class['DB']->run('select * from `picture` where `ItemType` = \'Temp\' 

								', 'picture.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'list temp picture ' //sql code subject	
			);
		$tempPictures = array();
		if ($max > 0)
		{
			for ($i = 0; $i < $max; $i++)
			{
				$tempPicture                = new picture();
				$row                        = $query[$i];
				$tempPicture->Id            = $row['id'];
				$tempPicture->Title         = $row['title'] ?: '';
				$tempPicture->PicturePath   = $row['picture_path'] ?: '';
				$tempPicture->UserId        = $row['user_id'] ?: 0;
				$tempPicture->CreateDate    = $row['create_date'] ?: '';
				$tempPicture->ItemId        = $row['item_id'] ?: 0;
				$tempPicture->ItemType      = $row['item_type'] ?: '';
				$tempPicture->Description   = $row['description'] ?: '';
				$tempPicture->ViewCount     = $row['view_count'] ?: 0;
				$tempPicture->LikeCount     = $row['like_count'] ?: 0;
				$tempPicture->MemberIndex   = $row['member_index'] ?: '';
				$tempPicture->ShajarenameId = $row['shajarename_id'] ?: 0;
				$tempPictures[$i]           = $tempPicture;
			} //for
			return $tempPictures;
		} //$max > 0
		else
		{
			return 404; // no result for query
		} //else
	} //func
	public function listPictureByItemType($itemType, $begin = 0, $end = 0)
	{
		return $this->searchPictures('', //title
			'', //date_begin
			'', //date_end
			0, //item
			$itemType, //ItemType
			'', //describe
			0, //user
			0, //Shajarename
			$begin, $end);
	}
	public function listPictureByItem($item, $itemType, $begin = 0, $end = 0)
	{
		return $this->searchPictures('', //title
			'', //date_begin
			'', //date_end
			$item, //item
			$itemType, //ItemType
			'', //describe
			0, //user
			0, //Shajarename
			$begin, $end);
	}
	public function listPictureByUser($user, $begin = 0, $end = 0)
	{
		return $this->searchPictures('', //title
			'', //date_begin
			'', //date_end
			0, //item
			'', //ItemType
			'', //describe
			$user, 0, //Shajarename
			$begin, $end);
	}
	public function listPictureByShajarename($Shajarename, $begin = 0, $end = 0)
	{
		return $this->searchPictures('', //title
			'', //date_begin
			'', //date_end
			0, //item
			'', //ItemType
			'', //describe
			0, //user
			$Shajarename, $begin, $end);
	}
	public function searchPictures($Title = '', $BeginCreateDate = '', $EndCreateDate = '', $ItemId = 0, $ItemType = '', $Description = '', $UserId = 0, $Shajarename = 0, $begin = 0, $end = 0, $accepted = -1)
	{
		$row = '';
		$max = 0;
		if ($BeginCreateDate != '')
			$EndCreateDate = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		if ($end > GSMS::$config['page_item_per_page'])
			$end = $end - $begin;
		$q = ($Title == '' ? '' : '`title` like \'%' . $Title . '%\'  ');
		$q .= ($BeginCreateDate == '' ? '' : ($q != '' ? ' and ' : '') . '`create_date` >=   \'' . $BeginCreateDate . '\'  and `create_date` <= \'' . $EndCreateDate . '\'');
		$q .= ($Description == '' ? '' : ($q != '' ? ' and ' : '') . '`description` like \'%' . $Description . '%\'   ');
		$q .= ($UserId == 0 ? '' : ($q != '' ? ' and ' : '') . '`user_id`=' . $UserId . '   ');
		$q .= ($ItemId == 0 ? '' : ($q != '' ? ' and ' : '') . '`item_id`=' . $ItemId . '   ');
		$q .= ($Shajarename == 0 ? '' : ($q != '' ? ' and ' : '') . '`shajarename_id`=' . $Shajarename . '   ');
		$q .= ($accepted == -1 ? '' : ($q != '' ? ' and ' : '') . '`accepted`=' . $accepted . '   ');
		$q .= ($ItemType == '' ? '' : ($q != '' ? ' and ' : '') . '`item_type`=\'' . $ItemType . '\'  ');
		if ($q != '')
			$q = ' where ' . $q;
		$q_count                 = 100;
		/*
		
		GSMS::$class['DB']->run('select count(*)as cnt from `picture` '.$q , 
		
		'picture.php',	//file of code
		
		$row,			//variable to return first row			
		
		$max,			//variable to return row count	
		
		'list picture '	//sql code subject	
		
		);
		
		*/
		$result_count            = $q_count;
		$_SESSION['query_count'] = $result_count;
		$_SESSION['query']       = 'select * from `picture`  ' . $q;
		$query                   = GSMS::$class['DB']->run('select * from `picture`  ' . $q . ' limit ' . $begin . ',' . $end, 'picture.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'list picture ' //sql code subject	
			);
		$tempPictures            = array();
		if ($result_count > 0)
		{
			for ($i = 0; $i < $max; $i++)
			{
				$tempPicture                = new picture();
				$row                        = $query[$i];
				$tempPicture->Id            = $row['id'];
				$tempPicture->Title         = $row['title'] ?: '';
				$tempPicture->PicturePath   = $row['picture_path'] ?: '';
				$tempPicture->UserId        = $row['user_id'] ?: 0;
				$tempPicture->CreateDate    = $row['create_date'] ?: '';
				$tempPicture->ItemId        = $row['item_id'] ?: 0;
				$tempPicture->ItemType      = $row['item_type'] ?: '';
				$tempPicture->Description   = $row['description'] ?: '';
				$tempPicture->ViewCount     = $row['view_count'] ?: 0;
				$tempPicture->LikeCount     = $row['like_count'] ?: 0;
				$tempPicture->MemberIndex   = $row['member_index'] ?: '';
				$tempPicture->ShajarenameId = $row['shajarename_id'] ?: 0;
				$tempPictures[$i]           = $tempPicture;
			} //for
			return array(
				$tempPictures,
				$begin,
				$result_count
			);
		} //$result_count > 0
		else
		{
			return 404; // no result for query
		} //else
	} //func
	public function review($sql, $result_count, $begin = 0, $end = 30)
	{
		$row          = 0;
		$max          = 0;
		$query        = GSMS::$class['DB']->run($sql . ' limit ' . $begin . ',' . $end, 'picture.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'review picture ' //sql code subject	
			);
		$tempPictures = array();
		if ($result_count > 0)
		{
			for ($i = 0; $i < $max; $i++)
			{
				$tempPicture                = new picture();
				$row                        = $query[$i];
				$tempPicture->Id            = $row['id'];
				$tempPicture->Title         = $row['title'] ?: '';
				$tempPicture->PicturePath   = $row['picture_path'] ?: '';
				$tempPicture->UserId        = $row['user_id'] ?: 0;
				$tempPicture->CreateDate    = $row['create_date'] ?: '';
				$tempPicture->ItemId        = $row['item_id'] ?: 0;
				$tempPicture->ItemType      = $row['item_type'] ?: '';
				$tempPicture->Description   = $row['description'] ?: '';
				$tempPicture->ViewCount     = $row['view_count'] ?: 0;
				$tempPicture->LikeCount     = $row['like_count'] ?: 0;
				$tempPicture->MemberIndex   = $row['member_index'] ?: '';
				$tempPicture->ShajarenameId = $row['shajarename_id'] ?: 0;
				$tempPictures[$i]           = $tempPicture;
			} //for
			return array(
				$tempPictures,
				$begin,
				$result_count
			);
		} //$result_count > 0
		else
		{
			return 404; // no result for query
		} //else
	}
	public function toString($id = 0)
	{
		if ($id == 0)
		{
			return $this->Title;
		} //$id == 0
		else
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('select `title` from  `picture` where `id`=' . $id, 'picture.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'select toString for picture' //sql code subject	
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
		GSMS::$class['DB']->run('select count(`id`)as cnt from  `picture` ', 'picture.php', $row, $max, 'select Count of pictures');
		return $row['cnt'];
	} //func
} //class
if (!defined("GSMS"))
{
	exit("Access denied");
} //!defined("GSMS")

