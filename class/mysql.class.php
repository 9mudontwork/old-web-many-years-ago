<?php
	/** MySQL hostname */
	define('APP_DB_HOST', 'localhost');

	/** MySQL database username */
	define('APP_DB_USER', 'admin_manga');

	/** MySQL database password */
	define('APP_DB_PASSWORD', '');

	/** MySQL database name */
	define('APP_DB_NAME', 'admin_manga');

	/** MySQL table prefix */
	define('APP_TABLES_PREFIX', '');
	
	$db = MySQLDatabase::GetInstance();
								
	class MySQLDatabase {
		private static $uniqueInstance;
		protected $connection;
		protected $settings;
		protected $show_errors = true;
		
		public function MySQLDatabase(){
			$this->Connect();
		}
		
		public static function GetInstance(){
			if(self::$uniqueInstance == null){
				self::$uniqueInstance = new MySQLDatabase();
			}
			return self::$uniqueInstance;
		}
		
		public function Connect() {
			$result = false;
			$this->connection = mysql_connect(APP_DB_HOST, APP_DB_USER, APP_DB_PASSWORD);
			if($this->connection) {
				$select_db = mysql_select_db(APP_DB_NAME, $this->connection);
				mysql_set_charset('utf8', $this->connection);
				if($select_db) {
					$result = true;
					} else {
					if($this->show_errors)
					die(mysql_error());
				}
				} else {
				if($this->show_errors)
				die(mysql_error());
			}
			return $result;
		}
		
		public function Close() {
			return   mysql_close($this->connection);
		}
		
		public function Create($table, $values) {
			$columns = $this->CommaSeparate(array_keys($values));
			$data = $this->CommaSeparateWithQuotes(array_values($values));
			
			$insertQuery = "INSERT INTO $table ( $columns ) VALUES ( $data )";
			//echo $insertQuery;
			$ins = mysql_query($insertQuery);
			if($ins) {
				return  mysql_insert_id();
				} else {
				if($this->show_errors)
				die(mysql_error() . ' Query:' . $insertQuery);
			}
			return 0;
		}
		
		public function Update($table, $where, $values) {
			$where = $this->ColumnValueString($where, 'AND');
			$values = $this->ColumnValueString($values, ',');
			
			$update = "UPDATE $table SET $values WHERE $where";
			$u = mysql_query($update);
			if($u) {
				return  mysql_affected_rows();
				} else {
				if($this->show_errors)
				die(mysql_error());
			}
			return 0;
		}
		
		public function Delete($table, $where) {
			$where = $this->ColumnValueString($where, 'AND');
			
			$delete = "DELETE FROM $table WHERE $where";
			
			$del = mysql_query($delete);
			if($del) {
				return  mysql_affected_rows();
				} else {
				if($this->show_errors)
				die(mysql_error());
			}
			return 0;
		}
		
		public function Query($table, $select =null, $where =null, $grouping =null, $having =null, $sort =null, $limit =null) {
			$results = array();
			
			if(is_array($select)) {
				$select = $this->CommaSeparate($select);
			}
			
			$selectQuery = "SELECT $select FROM " . $table;
			
			if($where != null) {
				if(is_array($where)) {
					$where = $this->ColumnValueString($where, 'AND');
				}
				$selectQuery .= " WHERE $where";
			}
			
			if($grouping != null) {
				$selectQuery .= " GROUP BY $grouping";
			}
			
			if($having != null) {
				$selectQuery .= " HAVING $having";
			}
			
			if($sort != null) {
				if(is_array($sort)) {
					$sorttemp = '';
					foreach($sort as $k => $v) {
						$sorttemp .= "$k $v,";
					}
					$sort = substr($sorttemp, 0, -1);
				}
				$selectQuery .= " ORDER BY $sort";
			}
			
			if($limit != null) {
				if(is_array($limit)) {
					$limit = $limit['offset'] . ", " . $limit['rows'];
				}
				$selectQuery .= " LIMIT $limit";
			}
			
			$query = mysql_query($selectQuery);
			if($query) {
				$numResults = mysql_num_rows($query);
				for($i = 0; $i < $numResults; $i++) {
					$row = mysql_fetch_assoc($query);
					$results[] = $row;
				}
				} else {
				if($this->show_errors)
				die(mysql_error() . ' Query:' . $selectQuery);
			}
			return $results;
		}
		
		public function DirectQuery($q) {
			$query = mysql_query($q);
			if (!$query) {
				if ($this->show_errors)
				die(mysql_error());
			}
			return $query;
		}
		
		protected function CommaSeparate($k) {
			for($i = 0; $i < count($k); $i++) {
				$k[$i] = $k[$i];
			}
			return  implode(', ', $k);
		}
		
		protected function CommaSeparateWithQuotes($v) {
			for($i = 0; $i < count($v); $i++) {
				if(is_string($v[$i])) {
					$v[$i] = "'" . $v[$i] . "'";
					} else {
					$v[$i] = $v[$i];
				}
			}
			
			return  implode(', ', $v);
		}
		
		protected function ColumnValueString($where, $separator) {
			$separator = " $separator ";
			$return = '';
			foreach($where as $k => $v) {
				$return .= $k . " = ";
				if(is_string($v)) {
					$return .= "'" . $v . "'";
					} else {
					$return .= $v;
				}
				$return .= $separator;
			}
			
			return  substr($return, 0, -strlen($separator));
		}
		
	}
?>