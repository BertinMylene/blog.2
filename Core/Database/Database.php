<?php

namespace Core\Database;

use \PDO;

/**
 * Connection to the database
 */
class Database
{
	/**
	 * Name of the data base
	 * @var $name
	 */
	private $name;

	/** 
	 * Database user name
	 * @var string $user 
	 */
	private $user;

	/**
	 * User password for the database
	 * @var string $pass
	 */
	private $pass;

	/**
	 * Server name for database 
	 * @var string $host
	 */
	private $host;

	/**
     * Database connection
     * @var 
     */
	private $database = null;

	/**
	 * Initializes attributes with database connection parameters
	 * @param string $name 
	 * @param string $user 
	 * @param string $pass (optional)
	 * @param string $host
	 */
	public function __construct(string $name = 'blog', string $user = 'root', string $pass = '', string $host = 'localhost')
	{
		$this->name = $name;
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
	}

	/**
	 * Check if a PDO instance exists
	 * Initialize a PDO instance and store it in the attribute
	 * @return PDO
	 */
	private function getPDO()
	{
		try {
			if ($this->database === null) {
				$pdo = new PDO('mysql:dbname=' . $this->name . ';host=' . $this->host, $this->user, $this->pass);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->database = $pdo;
			}
			return $this->database;
		} catch (\Exception $e) {
			var_dump($e);
		}
	}

	/** Executes the request it receives
	 * @param string $statement Request SQL
	 * @param string|null $className Return class for data recovery
	 * @param bool $oneResult (optional) 	Retrieve an item -> fetch
	 * 										Recover multiple items -> fetchAll
	 * @return [type]
	 */
	public function query(string $statement, string $className = null, bool $oneResult = false)
	{
		$results = $this->getPDO()->query($statement);
		try {
			if ($className === null) {
				$results->setFetchMode(PDO::FETCH_OBJ);
			} else {
				$results->setFetchMode(PDO::FETCH_CLASS, $className);
			}

			if ($oneResult) {
				$datas = $results->fetch();
			} else {
				$datas = $results->fetchAll();
			}
			return $datas;
		} catch (\Exception $e) {
			var_dump($e);
		}
	}

	/**
	 * Executes the prepared query it receives
	 * @param string $statement Request SQL
	 * @param array $parameters Parameters to add in the SQL query
	 * @param string|null $className Return class for data recovery
	 * @param bool $oneResult (optional) 	Retrieve an item -> fetch
	 * 										Recover multiple items -> fetchAll
	 * @param bool $noFetch If no data is recovered
	 * @return [type]
	 */
	public function prepare(string $statement, array $parameters, string $className = null, bool $oneResult = false, bool $noFetch = false)
	{
		$prep = $this->getPDO()->prepare($statement);
		try {
			if (!$noFetch) {
				$prep->execute($parameters);

				if ($className === null) {
					$prep->setFetchMode(PDO::FETCH_OBJ);
				} else {
					$prep->setFetchMode(PDO::FETCH_CLASS, $className);
				}

				if ($oneResult) {
					$datas = $prep->fetch();
				} else {
					$datas = $prep->fetchAll();
				}
				return $datas;
			} else {
				return $prep->execute($parameters);
			}
		} catch (\Exception $e) {
			var_dump($e);
		}
	}
	
	/**
	 * Retrieve the ID of the last item sent to the database
	 * @param string $tableName id table
	 * @return string id of last item
	 */
	public function lastInsertId(string $tableName)
	{
		return $this->database->lastInsertId($tableName);
	}
}
