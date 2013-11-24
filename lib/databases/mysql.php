<?php
# named mysql but use mysqli as MySQL engine #
namespace Theogony\Database;

class Mysql
{
	private $config;
	private $connection;
	private $command = array();
	private $duplicated = false;
	public function __construct($callback)
	{
		$this->config = new \Theogony\Struct\DataCollection();

		if (is_callable($callback))
			if (is_object($callback))
				$callback($this->config);
			else
				call_user_func_array($callback, $this->config);
		else
			throw new Exception\NotCallableFunctionException($callback);

		$this->connection = new \mysqli($this->config->host, $this->config->username, $this->config->password, $this->config->database, 3306);
		$this->connection->query("SET NAMES `UTF8`");

		// wipe data for security
		$this->config = null;
	}

	public function __clone()
	{
		$this->duplicated = true;
		$this->command = array();
	}

	public function from($table)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;
		
		if (isset($rtn->command['insert'])) {
			trigger_error('Already set for `INSERT` query, now will duplicated.', E_USER_WARNING);
			$rtn = clone $this;
		}
		$rtn->command['from'] = $this->connection->real_escape_string($table);

		return $rtn;
	}

	public function insert($table)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;

		if (isset($rtn->command['from'])) {
			trigger_error('Already set for `SELECT` query, now will duplicated.', E_USER_WARNING);
			$rtn= clone $this;
		}
		$rtn->command['insert'] = $this->connection->real_escape_string($table);

		return $rtn;
	}

	public function where($connection)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;

		$rtn->command['where'] = $this->__where($connection);

		return $rtn;
	}

	private function __where(&$condition)
	{
		$parts = array();
		$type = $condition[0] === ':or' ? ' OR ' : 'AND';
		foreach ($condition as $k => $v)
			if (is_numeric($k))
				if (is_array($v)) // sub case
					$parts[] = '(' . __where($v) . ')';
				else
					; // do nothing
			else // key => value
				if (is_array($v)) // in / like / operators / functions
					$parts[] = "`{$this->connection->real_escape_string($k)}` " . $this->__where_func($v);
				else
					$parts[] = "`{$this->connection->real_escape_string($k)}` = '{$this->connection->real_escape_string($v)}'";
		$rtn = implode($type, $parts);
		return $rtn;
	}

	private function __where_func(&$condition)
	{
		$rtn = '';
		switch ($condition[0])
		{
			case ':<>':
			case ':!=':
				$rtn = '<> ' . $this->connection->real_escape_string($connection[1]);
				break;
			case ':notin':
				unset($condition[0]);
				$rtn = 'NOT IN ( ' .
					implode(' , ', 
						array_map(function ($item) { return $this->connection->real_escape_string($item); }, $condition)
					) .
					' )';
				break;
			// case ':%':
			// case ':like':

			// case ':>':
			// case ':<':
			// case ':<=':
			// case ':>=':
			// case ':=':

			// case ':~':
			// case ':between':

			case ':(':
			case ':in':
			default:
				$rtn = 'IN ( ' .
					implode(' , ', 
						array_map(function ($item) { return $this->connection->real_escape_string($item); }, $condition)
					) .
					' )';
				break;
		}
		return $rtn;
	}

	public function value($pairs)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;

		if (!isset($this->command['value']))
			$this->command['value'] = array();
		foreach ($pairs as $k => $v)
			$this->command['value'][$this->connection->real_escape_string($k)] = $this->connection->real_escape_string($v);

		return $rtn;
	}

	public function limit($limit)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;

		$rtn->command['limit'] = intval($limit);

		return $rtn;
	}

	public function asc($order)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;
		
		if (!isset($rtn->command['order']))
			$rtn->command['order'] = [];
		$rtn->command['order'][$this->connection->real_escape_string($order)] = "ASC";

		return $rtn;
	}

	public function desc($order)
	{
		if (!$this->duplicated)
			$rtn = clone $this;
		else
			$rtn = $this;
		
		if (!isset($rtn->command['order']))
			$rtn->command['order'] = [];
		$rtn->command['order'][$this->connection->real_escape_string($order)] = "DESC";

		return $rtn;
	}

	public function run()
	{
		if (isset($this->command['from']))
		{
			$sql = 'SELECT * FROM `' . $this->command['from'] . '`';

			if (isset($this->command['where']))
				$sql .= ' WHERE ' . $this->command['where'];

			if (isset($this->command['order']))
				$sql .= ' ORDER BY ' . implode(', ',
					array_map(function ($k, $v) { return "`" . $k . "` " . $v; }, 
						array_keys($this->command['order']),
						array_values($this->command['order'])
					)
				);

			if (isset($this->command['limit']))
				$sql .= ' LIMIT ' . $this->command['limit'];

			$result = $this->connection->query($sql);
	
			$rtn = array();
			if ($result)
				while ($row = $result->fetch_assoc())
					$rtn[] = $row;
	
			return $rtn;
		}

		if (isset($this->command['insert']))
		{
			$sql = 'INSERT INTO `' . $this->command['insert'] . '`';

			if (!isset($this->command['value']))
				return array();
			
			$sql .= ' (`' . implode('`, `', array_keys($this->command['value'])) . '`)';
			$sql .= " VALUE ('" . implode("', '", array_values($this->command['value'])) . "')";

			$result = $this->connection->query($sql);
			
			if ($result)
				return array_merge(array('id' => $this->connection->insert_id), $this->command['value']);
			return array();
		}
	}
}
?>
