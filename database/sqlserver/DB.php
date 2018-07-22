<?php
//class for control mysql on model layer start 3-2-91 by nasser niazy in 
 class DB{
	 private $conection;
	function __construct()
	{
		
		$hostname_n =GSMS::$config['db_hostname'];
		$database_n = GSMS::$config['db_databasename'];
		$username_n = GSMS::$config['db_databaseuser'];
		$password_n =GSMS::$config['db_databasepass'];
		$this->conection= mysql_pconnect($hostname_n, $username_n, $password_n)or die('سایت در حال بروز رسانی است.');  
		mysql_select_db($database_n, $this->conection);
		mysql_set_charset(GSMS::$config['db_charset'],$this->conection);
		GSMS::$class['system_log']->log('debug', "mysql database engin Class Initialized");
	}//function
	private function logsql($sqlstring,$file,$userid,$username,$mymsg,$errCode,$errMessage)
	{
		$times=GSMS::$class['calendar']->date(GSMS::$config['date_format'],time(),GSMS::$config['date_gmt']);
		$ip=$this->getip();
		
		$str='insert into `sqlbug`(`error_code`,`describe`,`time`,`file`,`sql`,`user_id`,`message`,`userip`,`read`,`username`) 
				values(\''.$errCode.'\',\''.$errMessage.'\',\''.$times.'\',\''.$file.'\',\''.$sqlstring.
				'\',\''.$userid.'\',\''.$mymsg.'\',\''.$ip.'\',0,\''.$username.'\')';
		$R = mysql_query($str, $this->conection);
	}//fun
	
	public function run($sqlstring,$file,&$row='',&$max=0,$mymsg='')
	{
		$Result = mysql_query($sqlstring, $this->conection) ;
		if($Result)
		{
			if (is_bool($Result) === true) return $Result;//for update query
			$row = mysql_fetch_assoc($Result);
			$max = mysql_num_rows($Result); 
			if($max>0)
			{
				$result=array();
				for($i=0;$i<$max;$i++)
				{
					$result[$i]=$row;
					$row = mysql_fetch_assoc($Result);
				}//for
				$row = $result[0];
				mysql_free_result($Result);
				return $result;
			}
			else
			{
				return 0;
			}//else
		} 
		else
		{ 
			$message=str_replace('\'',"/",mysql_error($this->conection));
			$code=str_replace('\'',"/",mysql_errno($this->conection));
			$sqlstring=str_replace('\'',"/",$sqlstring);
			$user=GSMS::$class['session']->getUser();
    		$this->logsql($sqlstring,$file,$user['UserID'],$user['UserName'],$mymsg,$code ,$message);
			return 'error';
		}//else
	}//func	 
	public function getip()
	{
		if ($this->validip($_SERVER["HTTP_X_FORWARDED"])) 
		{
			return $_SERVER["HTTP_X_FORWARDED"]; 
		} elseif ($this->validip($_SERVER["HTTP_FORWARDED_FOR"])) 
		{
			return $_SERVER["HTTP_FORWARDED_FOR"];
		} elseif ($this->validip($_SERVER["HTTP_FORWARDED"])) 
		{
			return $_SERVER["HTTP_FORWARDED"];
		} elseif ($this->validip($_SERVER["HTTP_X_FORWARDED"])) 
		{
			return $_SERVER["HTTP_X_FORWARDED"];
		} else {
			return $_SERVER["REMOTE_ADDR"];
		}//if
	}//func
	private function validip($ip)
	{
		if (!empty($ip) && ip2long($ip)!= '-1')
		{
			$ReservedIps = array (
					array('0.0.0.0', '2.255.255.255'),
					array('10.0.0.0', '10.255.255.255'),
					array('127.0.0.0', '127.255.255.255'),
					array('169.254.0.0', '169.254.255.255'),
					array('172.16.0.0', '172.31.255.255'),
					array('192.0.2.0', '192.0.2.255'),
					array('192.168.0.0', '192.168.255.255'),
					array('255.255.255.0', '255.255.255.255')
					);
			foreach ($ReservedIps as $R)
			{
				$Min = ip2long($R['0']);
				$Max = ip2long($R['1']);
				if ((ip2long($ip) >= $Min) && (ip2long($ip) <= $Max)) return false;
			}//each
			return true;
		}else{
			return false;
		}//if
	}//fun 
	public function isExists($id,$table)
	{
		$user=(isset(GSMS::$class['session']) ? GSMS::$class['session']->getUser() : '');
		$user=$user['UserID'];
		$id=intval($id);
		$result=null;
		$row='';
		$max=0;
		$result=$this->run('select * from `'.$table.'` where `'.$table.'_id`='.$id,
					'db.sql',$row,$max,$user,'isExists '.$id.' on '.$table);
		return is_array($result) ;
	}//func
}//class
 if ( !defined( "GSMS" ) )exit( "Access denied" );

