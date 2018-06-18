<?php

class DB {

	private static $_instance = null;
	private $_pdo,//reps instantion of pdo object
			$_query,//last query execxuted
			$_error = false,//weather query failed or not
			$_results,//results set stored here
			$_count = 0;//count of the results

	private function __construct() {
		try { //try the PDO connection

			//database connection using PDO method
			$this->_pdo = new PDO('mysql:host='. Config::get('mysql/host') . ';dbname='. Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch(PDOException $e) { //catch PDO error: catch error in the try block

			die($e->getMessage());

		}
	}

	/*to check if we have already instantiated the object (conn to db),
	 if we haven't we instantiate it, if we have, we return the instance*/
	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()) {
		$this->_error = false;

		//check if query has been prepared properly
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}

	public function action($action, $table, $where = array(), $orderby = null) {
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=');

			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];

			if (!empty($orderby)) {
				
				$sql = "{$action} FROM activity WHERE {$field} {$operator} {$value} ORDER BY {$orderby[0]} {$orderby[1]}";

				$this->_query = $this->_pdo->prepare($sql);

				try {
					
					if (!$this->_query->execute()) {
						
						throw new Exception("Error getting ordered data from database.");
						
					}

					$this->_resultsOrdered = $this->_query->fetchAll(PDO::FETCH_OBJ);

					$this->_count = $this->_query->rowCount();

				} catch (Exception $e) {
					
					echo "Error: " . $e->getMessage();
				}
				return $this;
			}

			if (empty($orderby) && in_array($operator, $operators)) {

				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				
				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}

		}
		return false;

	}

	public function get($table, $where, $orderby = null) {

		if (!empty($orderby)) {
			return $this->action('SELECT *', $table, $where, $orderby);
		} else {
			return $this->action('SELECT *', $table, $where);
		}

	}

	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}

	public function insert($table, $fields = array()) {
		if (count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;

			foreach ($fields as $field) {
				$values .= '?';
				if ($x < count($fields)) {
					$values .= ', ';
				}
				$x++;
			}

			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
		}
		return false;
	}

	public function update($table, $field, $data, $fields) {

		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if ($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}


		$sql ="UPDATE {$table} SET {$set} WHERE {$field} = {$data}";

		if (!$this->query($sql, $fields)->error()) {
			return true;
		}

		return false;
	}

	public function lastId() {
		return $this->_pdo->lastInsertId();
	}

	public function results() {
		return $this->_results;
	}

	public function resultsOrdered() {
		return $this->_resultsOrdered;
	}

	public function first() {
		return $this->results()[0];
	}

 
	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}

}


?>