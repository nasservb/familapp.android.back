<?php
//allahoma sale ala mohammad va ale mohammad 
class admin
{
	public $id;
	public $name;
	public $family;
	public $mail;
	public $userName;
	public $password;
	public $describe;
	public $mobile;
	public $date;
	public $adminType;
	public $credit;
	public $is_block;
	public $blockdesc;
	public $block_date;
	public $sdk;
	public $model;
	public $line;
	public $phone;
	public $softversion;
	public $isVip;
	public $chatId;
	public $chatState;
	public $chatData;
	//public $permission;
	public function __construct()
	{
		$this->adminType = 0;
		GSMS::load('log', 'models');
		$this->date = GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG', 'admin class Initialized');
	} //fun
	function __set($propertyName, $propertyValue)
	{
		$this->propertyName = $propertyValue;
	} //fun
	public function save()
	{
		if ($this->id == 0)
		{
			$row      = '';
			$max      = 0;
			$this->id = GSMS::$class['DB']->run('INSERT INTO `admin` 
							(
								`admin_id` ,
								`name` ,
								`describe` ,
								`family`,
								`mail`,
								`username`,
								`password`,
								`admin_type`,
								`mobile`,
								`date` , 	
								`is_block`,
								`block_date`,
								`blockdesc`,
								`sdk`,
								`model`,
								`line`,
								`phone`,
								`softversion`,
								`is_vip`,
								`chat_id`,
								`chat_data`, 
								`chat_state`
							)
							VALUES 
							(
								NULL ,  
								\'' . $this->name . '\', 
								\'' . $this->describe . '\',  
								\'' . $this->family . '\',
								\'' . $this->mail . '\',
								\'' . $this->userName . '\',
								\'' . GSMS::$class['session']->encode($this->password) . '\',
								\'' . $this->adminType . '\',
								\'' . $this->mobile . '\',
								\'' . $this->date . '\',
								\'' . $this->is_block . '\',
								\'' . $this->block_date . '\', 
								\'' . $this->blockdesc . '\', 
								\'' . $this->sdk . '\', 
								\'' . $this->model . '\',
								\'' . $this->line . '\',
								\'' . $this->phone . '\',
								\'' . $this->softversion . '\',
								\'' . $this->isVip . '\',
								\'' . $this->chatId . '\',
								\'' . $this->chatData . '\', 
								\'' . $this->chatState . '\'

								)', 'admin.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'insert admin' //sql code subject	
				);
			//GSMS::$class['log']->Log('create admin','inserting admin'.$this->name,'admin.php','save');
			return 1;
		} //$this->id == 0
		else
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('UPDATE `admin`
							SET 
								`name`=\'' . $this->name . '\', 
								`describe`=\'' . $this->describe . '\',  
								`family`=\'' . $this->family . '\',
								`mail`=\'' . $this->mail . '\',
								`describe`=\'' . $this->describe . '\',
								`admin_type`=\'' . $this->adminType . '\',
								' . (isset($this->password) ? '`password`=\'' . GSMS::$class['session']->encode($this->password) . '\',' : '') . '`mobile`=\'' . $this->mobile . '\',
								`date`=\'' . $this->date . '\',
								`is_block`=\'' . $this->is_block . '\',
								`block_date`=\'' . $this->block_date . '\',
								`blockdesc`=\'' . $this->blockdesc . '\',
								`sdk`=\'' . $this->sdk . '\',
								`model`=\'' . $this->model . '\',
								`line`=\'' . $this->line . '\',
								`phone`=\'' . $this->phone . '\',
								`softversion`=\'' . $this->softversion . '\',
								`is_vip`=\'' . $this->isVip . '\',
								`chat_id`=\'' . $this->chatId . '\',
								`chat_data`=\'' . $this->chatData . '\',
								`chat_state`=\'' . $this->chatState . '\'
							WHERE `admin_id` =' . $this->id, 'admin.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'update admin' //sql code subject	
				);
			//GSMS::$class['log']->Log('edit admin','updating admin'.$this->name,'admin.php','save');
			return 1;
		} //else
	} //func
	// you not able to see someone who have not your child!
	public function listAdmins($type = 2 /*1=admin ,2=user ,3=photographer*/ , $begin = 0, $end = 0)
	{
		$user = GSMS::$class['session']->getUser();
		$row  = '';
		$max  = 0;
		if (intval($begin) == 0)
			$begin = 0;
		if (intval($end) == 0)
			$end = GSMS::$config['page_item_per_page'];
		$query      = GSMS::$class['DB']->run('select * from `admin` 

								WHERE `admin_type`=' . $type, 'admin.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'list admin ' //sql code subject	
			);
		$tempAdmins = array();
		if ($max > 0)
		{
			for ($i = 0; $i < $max; $i++)
			{
				$row            = $query[$i];
				$tempAdmins[$i] = $this->map($row);
			} //for
			return $tempAdmins;
		} //$max > 0
		else
		{
			return 404; // no result for query
		} //else
	} //func
	public function getAdmin($id)
	{
		$id = intval($id);
		if ($id > 0)
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('select * from `admin` where `admin_id`=' . $id, 'admin.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'select requested admin' //sql code subject	
				);
			if ($max > 0)
				return $this->map($row);
			else
				return 0;
		} //if
	} //func
	public function getAdminByUsername($username)
	{
		$row = '';
		$max = 0;
		GSMS::$class['DB']->run('select * from `admin` where `username`=\'' . $username . "'", 'admin.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'select requested admin' //sql code subject	
			);
		if ($max > 0)
			return $this->map($row);
		else
			return 0;
	} //func
	public function getAdminByToken($token)
	{
		$row = '';
		$max = 0;
		GSMS::$class['DB']->run('select * from `admin` where `line`=\'' . $token . "'", 'admin.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'select requested admin' //sql code subject	
			);
		if ($max > 0)
			return $this->map($row);
		else
			return 0;
	} //func
	public function getAdminByPhone($phone)
	{
		$row = '';
		$max = 0;
		GSMS::$class['DB']->run('select * from `admin` where `phone`=\'' . $phone . "'", 'admin.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'select requested admin' //sql code subject	
			);
		if ($max > 0)
			return $this->map($row);
		else
			return 0;
	} //func
	public function getAdminByChatid($chatid)
	{
		$row = '';
		$max = 0;
		GSMS::$class['DB']->run('select * from `admin` where `chat_id`=\'' . $chatid . "'", 'admin.php', //file of code
			$row, //variable to return first row			
			$max, //variable to return row count	
			'select requested admin' //sql code subject	
			);
		if ($max > 0)
			return $this->map($row);
		else
			return 0;
	} //func
	public function changePass($oldpass, $newpass)
	{
		if (GSMS::$class['session']->is_register('login_count') == false)
		{
			GSMS::$class['session']->register('login_count');
			GSMS::$class['session']->set('login_count', 0);
		} //if
		$validcount = GSMS::$class['session']->get('login_count');
		$validcount++;
		if ($validcount > 5)
			return 309; //	try count is out of max
		if ($oldpass == '' || $newpass == '')
			return 500; //insert user and pass
		$row  = '';
		$max  = 0;
		$user = GSMS::$class['session']->getUser();
		GSMS::$class['DB']->run("select * from `admin` where (`username`='" . $user['UserName'] . "')

											and(`password`='" . GSMS::$class['session']->encode($oldpass) . "')", 'admin.php', //	file of code
			$row, //variable to return first row
			$max, //variable to return row count
			'check pass'); //code subject
		if ($max == 0)
		{
			GSMS::$class['session']->set('login_count', $validcount);
			return 303; //dont match by any user pass
		} //$max == 0
		elseif ($max > 1)
		{
			GSMS::$class['DB']->logsql("select * from `admin` where (`username`='" . $user['UserName'] . "')

													and(`password`='" . $oldpass . "')", "admin.php", //error_file
				$user['UserID'], //user_id
				$user['UserName'], //user_name
				"report injection", //error_subject
				"", //error_code
				""); //error_message
			GSMS::$class['session']->set('login_count', $validcount);
			return 304; //try to injection
		} //$max > 1
		elseif ($max == 1)
		{
			$tempAdmin =& admin::getAdmin($user['UserID']);
			$tempAdmin->password = $newpass;
			$tempAdmin->save();
			return 45; //successfull update pass
		} //if
	} //func
	public function toString($id = 0)
	{
		if ($id == 0)
		{
			return $this->userName;
		} //$id == 0
		else
		{
			$row = '';
			$max = 0;
			GSMS::$class['DB']->run('select `username` from  `admin` where `admin_id`=' . $id, 'admin.php', //file of code
				$row, //variable to return first row			
				$max, //variable to return row count	
				'select toString for admin' //sql code subject	
				);
			if ($max == 1)
			{
				return $row['username'];
			} //$max == 1
			else
			{
				return 404;
			} //else
		} //else
	} //func
	public function map($row)
	{
		$tempAdmin              = new admin();
		$tempAdmin->id          = $row['admin_id'];
		$tempAdmin->name        = $row['name'] ?: '';
		$tempAdmin->family      = $row['family'] ?: '';
		$tempAdmin->mail        = $row['mail'] ?: '';
		$tempAdmin->userName    = $row['username'] ?: '';
		$tempAdmin->mobile      = $row['mobile'] ?: '';
		$tempAdmin->date        = $row['date'] ?: '';
		$tempAdmin->describe    = $row['describe'] ?: '';
		$tempAdmin->line        = $row['line'] ?: '';
		$tempAdmin->phone       = $row['phone'] ?: '';
		$tempAdmin->softversion = $row['softversion'] ?: 0;
		$tempAdmin->is_block    = $row['is_block'] ?: 0;
		$tempAdmin->block_date  = $row['block_date'] ?: '';
		$tempAdmin->blockdesc   = $row['blockdesc'] ?: '';
		$tempAdmin->isVip       = $row['is_vip'] ?: 0;
		$tempAdmin->chatId      = $row['chat_id'] ?: 0;
		$tempAdmin->chatData    = $row['chat_data'] ?: '';
		$tempAdmin->chatState   = $row['chat_state'] ?: 0;
		$tempAdmin->adminType   = $row['admin_type'] ?: 0;
		return $tempAdmin;
	}
	public function getCount($type)
	{
		$row = '';
		$max = 0;
		GSMS::$class['DB']->run('select count(`admin_id`)as cnt from  `admin` where  `admin_type`= ' . $type, 'admin.php', $row, $max, 'select getCount for admin');
		return $row['cnt'];
	} //func
} //class 
if (!defined("GSMS"))
{
	exit("Access denied");
} //!defined("GSMS")

