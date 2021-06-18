<?php
namespace Core\Database;

use \PDO;

/**
 * Se connecte à la base de donnée grâce au système PDO 
 * @package app
 */
class Database
{
	/** @var string $name Nom de la DB */
	private $name;

	/** @var string $name Nom d'utilisateur pour se connecter à DB */	
	private $user;
	
	/** @var string $name Password pour se connecter à la DB */	
	private $pass;

	/** @var string $name Nom du serveur où se trouve la DB */
	private $host;

	/** @var string $name Nom de la Table */
	private $database = null;

	/**
	 * Initialise les attributs avec les paramètres de connexion à la base de données
	 * @param string $name nom de la DB
	 * @param string $user nom d'utilisateur pour se connecter
	 * @param string $pass (optional) mot de passe pour se connecter
	 * @param string $host nom du serveur
	 * @return non
	 */
	public function __construct(string $name ='blog', string $user ='root', string $pass = '', string $host = 'localhost') {
		$this->name = $name;
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
	}

	/**
	 * Initialisation d'une instance de PDO qui sera stockée dans l'attribut prévu s'il n'existe pas encore et le retourne
	 * @access private
	 * @param none
	 * @return object PDO
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

	/**
	 * Fait une requête SQL qu'elle reçoit en paramètre
	 * @access public
	 * @param string $statement requête SQL
	 * @param string $className classe de retour pour la récupération des données
	 * @param bool $oneResult (optional) indique si on souhaite récupérer un élément et on fait un fetch ou plusieurs et on fait un fetchAll
	 * @return object $className objet retourné selon celui passé en paramètre
	 */
	public function query(string $statement, string $className = null, bool $oneResult = false) {
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
	 * Fait une requête SQL préparée qu'elle reçoit en paramètre
	 * @access public
	 * @param string $statement requête SQL
	 * @param array $parameters paramètre à ajouter dans la requête SQL
	 * @param string $className classe de retour pour la récupération des données
	 * @param bool $oneResult (optional) indique si on souhaite récupérer un élément et on fait un fetch ou plusieurs et on fait un fetchAll
	 * @return object $className objet retourné selon celui passé en paramètre
	 */
	public function prepare(string $statement, array $parameters, string $className = null, bool $oneResult = false, bool $noFetch = false) {
		$prep = $this->getPDO()->prepare($statement);
		try{
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
	 * Récupère l'ID du dernier élément envoyé à la DB
	 * @return string ID du dernier élément
	 **/
	public function lastInsertId(string $tableName)
	{
		return $this->database->lastInsertId($tableName);
	}
}