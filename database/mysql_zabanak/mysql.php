<?php //allahoma sale ala mohammad va ale mohammad


	/**
	 * mysql (query builder)
	 *
	 *  automatic creation of queries and managing connections to the database.
	 *
	 *  - automated creation of: insert, update, delete, select or run queries manually;
	 *  - can be used in auto-increment tables or tables with identities added manually;
	 *  - test all the data before executing the queries to prevent sql injections;
	 *  - supports parallel connections in the database from different servers;
	 *  - function to create a quick search query;
	 *  - debugging process for queries and database connections;
	 *  - return the results of a query in php object or array format.
	 *
	 * @version 1.3 2013/01/14
	 * @author  rodrigo brandao <rodrigo_brandao@me.com>
	 * @link    rodrigobrandao.me
	 * @license GNU public license
	 *
	 */
	class mysql
	{

		/**
		 * database connection
		 *
		 * @var object
		 */
		public $conn;

		/**
		 * query data object
		 *
		 * @var object|array
		 */
		private $values;

		/**
		 * database host
		 *
		 * @var string
		 */
		private $host = '';

		/**
		 * database user
		 *
		 * @var string
		 */
		private $user = '';

		/**
		 * database password
		 *
		 * @var string
		 */
		private $pass = '';

		/**
		 * database name
		 *
		 * @var string
		 */
		private $name = '';

		/**
		 * database charset
		 *
		 * @var string
		 */
		private $char = '';

		/**
		 * type of the return variable
		 *
		 * @var string
		 */
		private $variable = '';

		/**
		 * open the connection to the database
		 *
		 */
		public function __construct()
		{
			
			$this->host = GSMS::$config['db_hostname'];

			$this->user =  GSMS::$config['db_databaseuser'];

			$this->pass = GSMS::$config['db_databasepass'];

			$this->name = GSMS::$config['db_databasename'];

			$this->char = GSMS::$config['db_charset'];

			$this->variable = GSMS::$config['db_return_type'];
			
			@$this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->name);
			if (DB_DEBUG) {
				$this->debug("CONNECTED", $this->host, $this->conn);
			}
			if (!$this->conn) {
				
					GSMS::$class['system_log']->log('DEBUG','running_query, error in sql connecting '.
						' host: '.$this->host .
						',user:'.$this->user.
						',pass:'.$this->pass
						);
				die('site under construction .');
			}
			mysqli_query($this->conn, "set names utf8");
			
			//	echo $this->conn;
		}

		/**
		 * show the debug message
		 *
		 * @param string $name
		 * @param string $debug
		 * @param bool $test
		 */
		private function debug($name, $debug, $test)
		{
			/*if (strtolower($this->char) == "utf8") {
				$debug = utf8_encode($debug);
			}*/
			echo "<pre>" . $name . ": <font color='" . ($test ? "blue" : "red") . "'>" . $debug . "</font>";
			if (!$test) {
				echo "<br>ERROR: <font color='red'>(" . @mysqli_errno($this->conn) . ") " . @mysqli_error($this->conn) . "</font>";
			}
			echo "</pre>";
		}

		public function Get_Connection()
		{

			return $this->conn;
		}

		/**
		 * close the connection to the database
		 *
		 */
		public function __destruct()
		{
			@$close = mysqli_close($this->conn);
			if (!$close) {
				echo mysqli_error($this->conn);
				echo mysqli_errno($this->conn);
			}
			if (DB_DEBUG) {
				$this->debug("DESCONNECTED", $this->host, $close);
			}
		}

		/**
		 * get the next id
		 *
		 * @param string $table
		 * @param string $col
		 * @return int
		 */
		public function nextid($table, $col)
		{
			$sql = "SELECT IFNULL(MAX(" . $this->secure($col) . "),0) + 1 AS maximum FROM `" . $this->secure($table) . "`";
			$lines = $this->query($sql);

			return ($lines != null) ? (($this->variable == 'object') ? (int)$lines[0]->maximum : (int)$lines[0]["maximum"]) : null;
		}

		/**
		 * check the string against sql injection
		 *
		 * @param string $value
		 * @return string
		 */
		public function secure($value)
		{
			return @mysqli_real_escape_string($this->conn, $this->replace($value));

		}

		/**
		 * replace strings used in sql injection
		 *
		 * @param string $value
		 * @param bool $restore
		 * @return string
		 */
		private function replace($value, $restore = false)
		{
			$injection = array ("select", "insert", "delete", "table", "update", "trucate", "drop", "applet", "object", "--");
			if ($restore == false) {
				foreach ((array)$injection as $find)
					$value = str_ireplace($find . " ", "{{" . $find . "}}", $value);
			}
			else {
				foreach ((array)$injection as $find)
					$value = str_ireplace("{{" . $find . "}}", $find . " ", $value);
			}
			$value = $this->line_break($value);

			return $value;
		}

		/**
		 * replace strings used to break lines
		 *
		 * @param string $value
		 * @return string
		 */
		private function line_break($value)
		{
			$value = str_ireplace("\\n", "\n", $value);
			$value = str_ireplace("\\r", "\r", $value);
			$value = str_ireplace("\\", "", $value);
			$value = str_ireplace("\\", "", $value);

			return $value;
		}

		/**
		 * execute the query
		 * if is select query return the result lines
		 * if is insert query return the inserted id
		 *
		 * @param string $sql
		 * @return string|object
		 */
		public function query($sql)
		{
			if (strtolower($this->char) == "utf8") 
			{
				@$query = mysqli_query($this->conn, $sql);
			}

			if(!$query)
			{
				global $loader;
				$loader->load('jdf','lib','shamsi');
				$loader->load_class('input','core');
				
				$message=str_replace('\'',"/",mysqli_error($this->conn));
				$code=str_replace('\'',"/",mysqli_errno($this->conn));
				$sqlstring=str_replace('\'',"/",$sql);

				$user_id= (isset($_SESSION["Reseller_Id"]) ? $_SESSION["Reseller_Id"]:0);

				$values = array(
					'url'=>'',
					'text'=>'',
					'err'=>$message,
					'code'=>$code,
					'sql'=>$sqlstring,
					'user_id'=>$user_id,
					'file'=>'mysql',
					'action'=>'query',
					'ip'=>$loader->classes['input']->ip_address(),
					'date'=>standard_date_time(),
					'err_type'=>'db'				
					);

				if ( function_exists('Logs'))
					Logs('running_query',15,' error in sql errCode: '.$code,2);
				$loader->db_accounting->insert_Secure('tbl_security_log',$values,'','');
				return -1;
			}
			else {
				//$sqlstring = str_replace('\'', "/", $sql);
				//Logs('running_query', 4, ' sql : ' . $sqlstring);
			}
			
			
			if (DB_DEBUG) {
				$this->debug("SQL", $sql, $query);
			}
			if ((strtolower(substr(trim($sql), 0, 6)) == "select") && ($query != false)) 
			{
				$return = null;
				while ($line = mysqli_fetch_object($query)) {
					$new_line = ($this->variable == 'object') ? (object)null : (array)null;
					foreach ((array)$line as $key => $value) {
						
						//$value = $this->replace(((strtolower($this->char) == "utf8") ? utf8_encode($value) : $value), true);
						if ($this->variable == 'object') {
							$new_line->$key = $value;
						}
						else {
							$new_line["$key"] = $value;
						}
					}
					$return[] = $new_line;
				}
			}
			elseif (strtolower(substr($sql, 0, 6)) == "insert") {
				$return = mysqli_insert_id($this->conn);
			}
			else {
				$return = mysqli_affected_rows($this->conn);
			}

			return $return;
		}

		/**
		 * execute the insert query
		 *
		 * @param string $table
		 * @param array|object $values
		 * @param string $where
		 * @param string $is
		 * @return int
		 */
		public function insert_Secure($table, $values, $where = null, $is = null)
		{
			if ($where != null) {
				$keys[] = "`" . $this->secure($where) . "`";
				$vals[] = "'" . $this->secure($is) . "'";
			}
			foreach ((array)$values as $key => $value) {
				$keys[] = "`" . $this->secure($key) . "`";
				$vals[] = "'" . $this->secure($value) . "'";
			}
			$sql = "INSERT INTO `" . strtolower($this->secure($table)) . "` (" . implode(",", $keys) . ") VALUES (" . implode(",", $vals) . ")";

			return $this->query($sql);
		}

		/**
		 * execute the delete query
		 *
		 * @param string $table
		 * @param string $where
		 * @param string $is
		 * @return int
		 */
		public function delete($table, $where, $is)
		{
			$where = $this->wheres($where, $is);
			$sql = "DELETE FROM `" . strtolower($this->secure($table)) . "` WHERE " . $where;

			return $this->query($sql);
		}

		/**
		 * create the 'where' area of the query
		 * check if is array and implode the values
		 *
		 * @param string|array $where
		 * @param string|array $is
		 * @param string $concat
		 * @return string
		 */
		private function wheres($where, $is, $concat = "AND")
		{
			if (($where != null) && ($is != null)) {
				if (is_array($where)) {
					for ($i = 0, $t = count($where); $i < $t; $i++)
						$array[] = "`" . $this->secure($where[$i]) . "`='" . $this->secure($is[$i]) . "'";
					$where = implode(" " . $concat . " ", $array);
				}
				else {
					$where = "`" . $this->secure($where) . "`='" . $this->secure($is) . "'";
				}
			}

			return $where;
		}

		/**
		 * execute the update query
		 *
		 * @param string $table
		 * @param array|object $values
		 * @param string $where
		 * @param string $is
		 * @return int
		 */
		public function update($table, $values, $where)
		{
			foreach ((array)$values as $key => $value)
				$updates[] = "`" . $this->secure($key) . "`='" . $this->secure($value) . "'";
			$sql = "UPDATE `" . strtolower($this->secure($table)) . "` SET " . implode(",", $updates) . " WHERE " . $where;

			return $this->query($sql);
		}

		/**
		 * execute the simple update query
		 *
		 * @param string $table
		 * @param array|object $values
		 * @param string $where
		 * @param string $is
		 * @return int
		 */
		public function simple_update($table, $values, $where, $is)
		{
			$where = $this->wheres($where, $is);
			foreach ((array)$values as $key => $value)
				$updates[] = "`" . $this->secure($key) . "`='" . $this->secure($value) . "'";
			$sql = "UPDATE `" . $this->secure($table) . "` SET " . implode(",", $updates) . " WHERE " . $where;

			return $this->query($sql);
		}

		/**
		 * discouraged
		 */
		public function sselect($table, $cols = "*", $where = null, $is = null, $order = null, $ini = null, $end = null)
		{
			return $this->simple_select($table, $cols, $where, $is, $order, $ini, $end);
		}

		/**
		 * execute the simple select query
		 *
		 * @param string $table
		 * @param string $cols
		 * @param string|array $where
		 * @param string|array $is
		 * @param string $order
		 * @param int $ini
		 * @param int $end
		 * @return object
		 */
		public function simple_select($table, $cols = "*", $where = null, $is = null, $order = null, $ini = null, $end = null)
		{
			$where = $this->wheres($where, $is);

			return $this->select($table, $cols, $where, $order, $ini, $end);
		}

		/**
		 * execute the select query
		 *
		 * @param string $table
		 * @param string $cols
		 * @param string $where
		 * @param string $order
		 * @param int $ini
		 * @param int $end
		 * @return object
		 */
		public function select($table, $cols = "*", $where = null, $order = null, $ini = null, $end = null)
		{
			if (!is_array($cols) && ($cols != null) && ($cols != "*")) {
				$cols = explode(",", trim($cols));
			}
			foreach ((array)$cols as $col)
				$rcols[] = "" . $this->secure($col) . "";
			if (!is_array($order) && ($order != null)) {
				$order = explode(",", trim($order));
			}
			foreach ((array)$order as $ord)
				$rorder[] = "`" . $this->secure($ord) . "`";
			$sql = "SELECT " . ((($cols != null) && ($cols != "*")) ? implode(", ", $rcols) : "*") . " FROM `" . strtolower($this->secure($table)) . "`";
			//echo $sql;
			if ($where != null) {
				$sql .= " WHERE " . $this->replace($where);
			}
			if ($order != null) {
				$sql .= " ORDER BY " . implode(", ", $rorder);
			}
			if ($end != null) {
				$sql .= " LIMIT " . (int)$ini . "," . (int)$end;
			}

			//echo $sql;
			return $this->query($sql);
		}

		/**
		 * execute the select query for search
		 *
		 * @param string $table
		 * @param string|array $cols
		 * @param string|array $search
		 * @param string $is
		 * @return object
		 */
		public function search($table, $cols = "*", $search, $is, $order = null, $ini = null, $end = null)
		{
			if (is_array($search)) {
				foreach ((array)$search as $current)
					$where[] = "`" . $this->secure($current) . "` LIKE '" . $this->secure($is) . "'";
			}
			else {
				$where[] = "`" . $this->secure($search) . "` LIKE '" . $this->secure($is) . "'";
			}
			$where = implode(" OR ", $where);

			return $this->select($table, $cols, $where, $order, $ini, $end);
		}

	}

	if (!defined('ZABANAK')) {exit('امکان دسترسی مستقیم وجود ندارد');}