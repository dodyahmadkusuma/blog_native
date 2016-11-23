<<<<<<< HEAD
<?php namespace _config;

	class Config {
		var $SQL = "";
		var $SQL_from = "";
		var $SQL_where = "";
		var $SQL_order = "";
		var $SQL_update = "";
		var $SQL_where_update = "";
		var $SQL_delete = "";
		var $SQL_where_delete = "";
		var $resultData = "";

		public function __construct() {
			

			$conn = mysql_connect('localhost', 'root', '');
			mysql_select_db('www', $conn);
		}

		public function select($field = "*") {
			if (is_array($field)) {
				$this->SQL .= "SELECT " .implode(", ", $field) ." ";
			} else {
				if ($this->SQL == '') {
					$this->SQL .= "SELECT " .$field ." ";
				} else {
					$this->SQL .= ", " .$field ." ";
				}
			}
		}

		public function query($query) {
			$this->SQL .= $query;
		}

		public function from($table) {
			if (is_array($table)) {
				$this->SQL_from .= "FROM " .implode(", ", $table) ." ";

			} else {
				if ($this->SQL_from == '') {
					$this->SQL_from .= "FROM " .$table ." ";
				} else {
					$this->SQL_from .= ", " .$table ." ";
				}
			}
		}

		public function where($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where .= "AND " .$key ." = " .$value ." ";
					}
				}
			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where .= "AND " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function or_where($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where .= "OR " .$key ." = " .$value ." ";
					}
				}

			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where .= "OR " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function like($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." LIKE '%" .$value ."%'";
					} else {
						$this->SQL_where .= "OR " .$key ." LIKE '%" .$value ."%' ";
					}
				}

			} else {
				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." LIKE '%" .$value ."%' ";
				} else {
					$this->SQL_where .= "OR " .$tableCondition ." LIKE '%" .$value ."%' ";
				}
			}
		}

		public function and_like($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." LIKE '%" .$value ."%'";
					} else {
						$this->SQL_where .= "AND " .$key ." LIKE '%" .$value ."%' ";
					}
				}

			} else {
				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." LIKE '%" .$value ."%' ";
				} else {
					$this->SQL_where .= "AND " .$tableCondition ." LIKE '%" .$value ."%' ";
				}
			}
		}

		public function order($field, $value = "") {
			if (is_array($field)) {
				foreach ($field as $key => $value) {
					if ($this->SQL_order == '') {
						$this->SQL_order .= "ORDER BY " .$value ." " .$key ." ";
					} else {
						$this->SQL_order .= ", " .$value ." " .$key ." ";
					}
				}

			} else {
				if ($this->SQL_order == '') {
					$this->SQL_order .= "ORDER BY " .$field ." " .$value ." ";
				} else {
					$this->SQL_order .= ", " .$field ." " .$value ." ";
				}
			}
		}

		public function get() {
			$this->resultData = "";

			$this->SQL .= $this->SQL_from .$this->SQL_where .$this->SQL_order;
			$result = mysql_query($this->SQL);
			$index = 0;
			while ($data = mysql_fetch_array($result)) {
				foreach ($data as $key => $value) {
					$this->resultData[$index][$key] = $value;
				}
				$index++;
			}

			$this->reset();

			return $this->resultData;
		}

		public function insert($table, $data) {
			$index = 0;
			foreach ($data as $key => $value) {
				$Keys[$index] = $key;
				$index++;
			}

			foreach ($data as $key => $value) {
				$data[$key] = "'" .$value ."'";
			}

			$SQL_insert = "INSERT INTO " .$table ."(" .implode(", ", $Keys) .") VALUES (" .implode(", ", $data) .")";

			$result = mysql_query($SQL_insert);

			return $result;
		}

		public function update($table, $data) {
			$this->SQL_update .= "UPDATE " .$table ." SET ";

			$index = 0;
			foreach ($data as $key => $value) {
				$Keys[$index] = $key;
				$index++;
			}

			foreach ($data as $key => $value) {
				$data[$key] = "'" .$value ."'";
			}

			$last = 0;
			foreach ($data as $key => $value) {
				$last++;
				$this->SQL_update .= $key ." = " .$value;
				if (count($data) > 1) {
					if ($last != count($data)) {
						$this->SQL_update .= ", ";
					} else {
						$this->SQL_update .= " ";
					}
				}
			}
		}

		public function where_update($tableCondition, $value="") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where_update == '') {
						$this->SQL_where_update .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where_update .= "AND " .$key ." = " .$value ." ";
					}
				}
			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where_update == '') {
					$this->SQL_where_update .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where_update .= "AND " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function getUpdate() {
			$this->SQL_update .= $this->SQL_where_update;

			$result = mysql_query($this->SQL_update);

			$this->SQL_update = "";

			return $result;
		}

		public function delete($table) {
			$this->SQL_delete .= "DELETE FROM " .$table ." ";
		}

		public function where_delete($tableCondition, $value="") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where_delete == '') {
						$this->SQL_where_delete .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where_delete .= "OR " .$key ." = " .$value ." ";
					}
				}
			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where_delete == '') {
					$this->SQL_where_delete .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where_delete .= "OR " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function getDelete() {
			$this->SQL_delete .= $this->SQL_where_delete;

			$result = mysql_query($this->SQL_delete);

			$this->SQL_delete = "";
			return $result;
		}

		public function reset() {
			$this->SQL = "";
			$this->SQL_from = "";
			$this->SQL_where = "";
			$this->SQL_order = "";
		}
	}




=======
<?php namespace _config;

	class Config {
		var $SQL = "";
		var $SQL_from = "";
		var $SQL_where = "";
		var $SQL_order = "";
		var $SQL_update = "";
		var $SQL_where_update = "";
		var $SQL_delete = "";
		var $SQL_where_delete = "";
		var $resultData = "";

		public function __construct() {
			

			$conn = mysql_connect('localhost', 'root', '');
			mysql_select_db('www', $conn);
		}

		public function select($field = "*") {
			if (is_array($field)) {
				$this->SQL .= "SELECT " .implode(", ", $field) ." ";
			} else {
				if ($this->SQL == '') {
					$this->SQL .= "SELECT " .$field ." ";
				} else {
					$this->SQL .= ", " .$field ." ";
				}
			}
		}

		public function query($query) {
			$this->SQL .= $query;
		}

		public function from($table) {
			if (is_array($table)) {
				$this->SQL_from .= "FROM " .implode(", ", $table) ." ";

			} else {
				if ($this->SQL_from == '') {
					$this->SQL_from .= "FROM " .$table ." ";
				} else {
					$this->SQL_from .= ", " .$table ." ";
				}
			}
		}

		public function where($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where .= "AND " .$key ." = " .$value ." ";
					}
				}
			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where .= "AND " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function or_where($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where .= "OR " .$key ." = " .$value ." ";
					}
				}

			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where .= "OR " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function like($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." LIKE '%" .$value ."%'";
					} else {
						$this->SQL_where .= "OR " .$key ." LIKE '%" .$value ."%' ";
					}
				}

			} else {
				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." LIKE '%" .$value ."%' ";
				} else {
					$this->SQL_where .= "OR " .$tableCondition ." LIKE '%" .$value ."%' ";
				}
			}
		}

		public function and_like($tableCondition, $value = "") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if ($this->SQL_where == '') {
						$this->SQL_where .= "WHERE " .$key ." LIKE '%" .$value ."%'";
					} else {
						$this->SQL_where .= "AND " .$key ." LIKE '%" .$value ."%' ";
					}
				}

			} else {
				if ($this->SQL_where == '') {
					$this->SQL_where .= "WHERE " .$tableCondition ." LIKE '%" .$value ."%' ";
				} else {
					$this->SQL_where .= "AND " .$tableCondition ." LIKE '%" .$value ."%' ";
				}
			}
		}

		public function order($field, $value = "") {
			if (is_array($field)) {
				foreach ($field as $key => $value) {
					if ($this->SQL_order == '') {
						$this->SQL_order .= "ORDER BY " .$value ." " .$key ." ";
					} else {
						$this->SQL_order .= ", " .$value ." " .$key ." ";
					}
				}

			} else {
				if ($this->SQL_order == '') {
					$this->SQL_order .= "ORDER BY " .$field ." " .$value ." ";
				} else {
					$this->SQL_order .= ", " .$field ." " .$value ." ";
				}
			}
		}

		public function get() {
			$this->resultData = "";

			$this->SQL .= $this->SQL_from .$this->SQL_where .$this->SQL_order;
			$result = mysql_query($this->SQL);
			$index = 0;
			while ($data = mysql_fetch_array($result)) {
				foreach ($data as $key => $value) {
					$this->resultData[$index][$key] = $value;
				}
				$index++;
			}

			$this->reset();

			return $this->resultData;
		}

		public function insert($table, $data) {
			$index = 0;
			foreach ($data as $key => $value) {
				$Keys[$index] = $key;
				$index++;
			}

			foreach ($data as $key => $value) {
				$data[$key] = "'" .$value ."'";
			}

			$SQL_insert = "INSERT INTO " .$table ."(" .implode(", ", $Keys) .") VALUES (" .implode(", ", $data) .")";

			$result = mysql_query($SQL_insert);

			return $result;
		}

		public function update($table, $data) {
			$this->SQL_update .= "UPDATE " .$table ." SET ";

			$index = 0;
			foreach ($data as $key => $value) {
				$Keys[$index] = $key;
				$index++;
			}

			foreach ($data as $key => $value) {
				$data[$key] = "'" .$value ."'";
			}

			$last = 0;
			foreach ($data as $key => $value) {
				$last++;
				$this->SQL_update .= $key ." = " .$value;
				if (count($data) > 1) {
					if ($last != count($data)) {
						$this->SQL_update .= ", ";
					} else {
						$this->SQL_update .= " ";
					}
				}
			}
		}

		public function where_update($tableCondition, $value="") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where_update == '') {
						$this->SQL_where_update .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where_update .= "AND " .$key ." = " .$value ." ";
					}
				}
			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where_update == '') {
					$this->SQL_where_update .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where_update .= "AND " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function getUpdate() {
			$this->SQL_update .= $this->SQL_where_update;

			$result = mysql_query($this->SQL_update);

			$this->SQL_update = "";

			return $result;
		}

		public function delete($table) {
			$this->SQL_delete .= "DELETE FROM " .$table ." ";
		}

		public function where_delete($tableCondition, $value="") {
			if (is_array($tableCondition)) {
				foreach ($tableCondition as $key => $value) {
					if (strpos($value, ".") == '') {
						$value = "'" .$value ."'";
					}

					if ($this->SQL_where_delete == '') {
						$this->SQL_where_delete .= "WHERE " .$key ." = " .$value ." ";
					} else {
						$this->SQL_where_delete .= "OR " .$key ." = " .$value ." ";
					}
				}
			} else {
				if (strpos($value, ".") == '') {
					$value = "'" .$value ."'";
				}

				if ($this->SQL_where_delete == '') {
					$this->SQL_where_delete .= "WHERE " .$tableCondition ." = " .$value ." ";
				} else {
					$this->SQL_where_delete .= "OR " .$tableCondition ." = " .$value ." ";
				}
			}
		}

		public function getDelete() {
			$this->SQL_delete .= $this->SQL_where_delete;

			$result = mysql_query($this->SQL_delete);

			$this->SQL_delete = "";
			return $result;
		}

		public function reset() {
			$this->SQL = "";
			$this->SQL_from = "";
			$this->SQL_where = "";
			$this->SQL_order = "";
		}
	}




>>>>>>> fac416ddeaafeb63a6c9be7da51eb0e509d06404
?>