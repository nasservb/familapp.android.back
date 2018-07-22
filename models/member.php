<?php //allahoma sale ala mohammad va ale mohammad 


class member
{
	public $id;
	public $name;
	public $family;
	public $birthdate;
	public $userId;
	public $isMale;
	public $isDied;
	public $phoneNumber;
	public $photos;
	public $partners;
	public $fatherId;
	public $motherId;
	public $childs;
	public $level;
	public $describtion;
	public $index;
	public $shajarenameId;
	public $diedDate;
	public function __construct()
	{
		GSMS::load('log', 'models');
		$this->id         = 0;
		$this->readed     = 0;
		$user             = GSMS::$class['session']->getUser();
		$this->userId     = $user['UserID'];
		$this->CreateDate = GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG', 'member class Initialized');
	} //fun
	function __set($propertyName, $propertyValue)
	{
		$this->propertyName = $propertyValue;
	} //fun
	public function save()
	{
		$tempMember = R::dispense('member');
		if ($this->id != 0)
		{
			list($tempMember) = R::load('member', $this->id);
		} //$this->id != 0
		$tempMember->name          = $this->name;
		$tempMember->family        = $this->family;
		$tempMember->birthdate     = $this->birthdate;
		$tempMember->userId        = $this->userId;
		$tempMember->isMale        = $this->isMale;
		$tempMember->isDied        = $this->isDied;
		$tempMember->phoneNumber   = $this->phoneNumber;
		$tempMember->photos        = $this->photos;
		$tempMember->partners      = $this->partners;
		$tempMember->fatherId      = $this->fatherId;
		$tempMember->motherId      = $this->motherId;
		$tempMember->childs        = $this->childs;
		$tempMember->level         = $this->level;
		$tempMember->describtion   = $this->describtion;
		$tempMember->index         = $this->index;
		$tempMember->shajarenameId = $this->shajarenameId;
		$tempMember->diedDate      = $this->diedDate;
		$this->id                  = R::store($tempMember);
	} //func
	public function listMembers($begin = 0, $end = 0)
	{
		$tempMembers = R::dispense('member');
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		$query       = 'select * from `member` ';
		$rowCount    = count(R::getAll($query));
		$tempMembers = R::getAll($query . ' limit ' . $begin . ',' . $end);
		if (count($tempMembers) > 0)
		{
			return array(
				$this->map($tempMembers),
				$begin,
				$rowCount
			);
		} //count($tempMembers) > 0
		else
		{
			return 0; // no result for query
		} //else
	} //func
	public function getMember($id)
	{
		$id = intval($id);
		if ($id > 0)
		{
			GSMS::$class['DB']->run('select *  from  `member` where id =' . $id, 'member.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'member ' //sql code subject	
				);
			$temp = array();
			if ($max == 0)
				return array();
			else
			{
				$temp = $this->map(array(
					$row
				));
			}
			return $temp[0];
		} //if
		return 0;
	} //func
	public function deleteMember($id = 0)
	{
		$id = intval($id);
		if ($id == 0)
			$id = $this->id;
		if ($id > 0)
		{
			$tempMember = R::dispense('member');
			$tempMember = R::exec('delete   from `member` where `id`=' . $id);
			return 1;
		} //if
		return 0;
	} //func
	
	public function deleteMemberByShajarename($shajarename)
	{
		$tempMember = R::dispense('member');
		R::exec('delete   from `member` where `shajarename_id`=' . $shajarename);
	}
	
	public function listMemberByShajarename($shajarename, $begin = 0, $end = 0)
	{
		return $this->searchMember('', //name
			'', //family
			'', //date_begin
			'', //date_end
			$shajarename, //shajarename
			'', //describe
			0, //user
			0, //phone
			$begin, $end);
	}
	
	public function searchMember($Name = '', $Family = '', $BeginCreateDate = '', $EndCreateDate = '', $shajarenameId = 0, $Describe = '', $UserId = 0, $Phone = 0, $begin = 0, $end = 0)
	{
		if ($BeginCreateDate != '')
			$EndCreateDate = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		$q = '';
		$q .= ($Name == '' ? '' : '`name` like \'%' . $Name . '%\'  ');
		$q .= ($Family == '' ? '' : '`family` like \'%' . $Family . '%\'  ');
		$q .= ($BeginCreateDate == '' ? '' : ($q != '' ? ' and ' : '') . '`create_date` >=   \'' . $BeginCreateDate . '\'  and `create_date` <= \'' . $EndCreateDate . '\'');
		$q .= ($Describe == '' ? '' : ($q != '' ? ' and ' : '') . '`describtion` like \'%' . $Describe . '%\'   ');
		$q .= ($UserId == 0 ? '' : ($q != '' ? ' and ' : '') . '`user_id`=' . $UserId . '   ');
		$q .= ($shajarenameId == 0 ? '' : ($q != '' ? ' and ' : '') . '`shajarename_id`=' . $shajarenameId . '   ');
		$q .= ($Phone == 0 ? '' : ($q != '' ? ' and ' : '') . '`phone`=' . $Phone . '   ');
		if ($q != '')
			$q = ' where ' . $q;
		$tempMember              = R::dispense('member');
		$query                   = 'select * from `member`  ';
		$rowCount                = count(R::getAll($query . $q));
		$tempMembers             = R::getAll($query . $q . ' limit ' . $begin . ',' . $end);
		$_SESSION['query_count'] = $rowCount;
		$_SESSION['query']       = $query;
		if ($rowCount > 0)
		{
			return array(
				$this->map($tempMembers),
				$begin,
				$rowCount
			);
		} //$rowCount > 0
		else
		{
			return 0; // no result for query
		} //else
	} //func
	public function toString()
	{
		return $this->name . ' ' . $this->family;
	} //func
	private function map($row)
	{
		$tempMembers = array();
		$count       = count($row);
		for ($i = 0; $i < $count; $i++)
		{
			$tempMember                = new member();
			$tempMember->id            = $row[$i]['id'];
			$tempMember->name          = $row[$i]['name'] ?: '';
			$tempMember->family        = $row[$i]['family'] ?: '';
			$tempMember->birthdate     = $row[$i]['birthdate'] ?: '';
			$tempMember->userId        = $row[$i]['user_id'] ?: 0;
			$tempMember->isMale        = $row[$i]['is_male'] ?: 0;
			$tempMember->isDied        = $row[$i]['is_died'] ?: 0;
			$tempMember->phoneNumber   = $row[$i]['phone_number'] ?: '';
			$tempMember->photos        = $row[$i]['photos'] ?: '';
			$tempMember->partners      = $row[$i]['partners'] ?: '';
			$tempMember->fatherId      = $row[$i]['father_id'] ?: 0;
			$tempMember->motherId      = $row[$i]['mother_id'] ?: 0;
			$tempMember->childs        = $row[$i]['childs'] ?: '';
			$tempMember->level         = $row[$i]['level'] ?: 0;
			$tempMember->describtion   = $row[$i]['describtion'] ?: '';
			$tempMember->index         = $row[$i]['index'] ?: 0;
			$tempMember->shajarenameId = $row[$i]['shajarename_id'] ?: 0;
			$tempMember->diedDate      = $row[$i]['died_date'] ?: '';
			$tempMembers[]             = $tempMember;
		} //$i = 0; $i < $count; $i++
		return $tempMembers;
	}
	public function getCount()
	{
		$tempMember = R::dispense('member');
		$row        = R::getAll('select count(`id`)as cnt from  `member` ');
		return $row[0]['cnt'];
	} //func
} //class
if (!defined("GSMS"))
{
	exit("Access denied");
} //!defined("GSMS")

