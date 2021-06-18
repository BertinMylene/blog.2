<?php

namespace Core\Table;

use Core\Database\Database;

/**
 * Classe mère de tous les appels à la bd
 */
abstract class Table
{
	/** @var string $table Nom de la Table en ligne */
	protected $table;

	/** @var Object \Core\Database $database Instance de la DB */
	protected $database;

	/**
	 * Initialise le nom de la table
	 */
	public function __construct(Database $database)
	{
		$this->database = $database;
		try {
			if ($this->table === null) {
				$parts = explode('\\', get_class($this));
				$class_name = end($parts);
				$this->table = strtolower(str_replace('Table', '', $class_name));
			}
		} catch (\Exception $e) {
			var_dump($e);
		}
	}

	/**
	 * Appelle tous les éléments du modèle passé en paramètre
	 * 
	 * @return array Tableau avec tous les éléments à renvoyer
	 */
	public function all()
	{
		try {
			return $this->query('SELECT * FROM ' . $this->table);
		} catch (\Exception $e) {
			var_dump($e);
		}
	}


	/**
	 * Récupère un élément selon la table
	 * 
	 * @param string $id ID de l'élément à récupérer
	 * @return object Objet du type de la table appelée
	 */
	public function find(string $id)
	{
		try {
			return $this->query('SELECT * FROM ' . $this->table . ' WHERE id=?', array($id), true);
		} catch (\Exception $e) {
			var_dump($e);
		}
	}

	/**
	 * @param mixed $statement
	 * @param null $attributes
	 * @param bool $one
	 * 
	 * @return [type]
	 */
	public function query($statement, $attributes = null, $one = false)
	{
		try {
			if ($attributes) {
				return $this->database->prepare(
					$statement,
					$attributes,
					str_replace('Table', 'Entity', get_class($this)),
					$one
				);
			}
			return $this->database->query(
				$statement,
				str_replace('Table', 'Entity', get_class($this)),
				$one
			);
		} catch (\Exception $e) {
			var_dump($e);
		}
	}


	public function update($colId, $fields)
	{
		try {
			$sql_parts = [];
			$attributes = [];
			foreach ($fields as $key => $value) {
				$sql_parts[] = "$key = ?";
				$attributes[] = $value;
			}
			$attributes[] = $colId;
			$sql_part = implode(', ', $sql_parts);
			return $this->query("UPDATE {$this->table} SET $sql_part WHERE id = ?", $attributes, true);
		} catch (\Exception $e) {
			var_dump($e);
		}
	}


	/**
	 * Supprimer un élément de la BD
	 *
	 * @param string $id ID de l'élément à supprimer
	 **/
	public function delete(string $colId)
	{
		try {
			return $this->database->prepare('DELETE FROM `' . $this->table . '` WHERE id=?', [$colId], $this->table, true, true);
		} catch (\Exception $e) {
			var_dump($e);
		}
	}


	public function create($fields)
	{
		try {
			$sql_parts = [];
			$attributes = [];
			foreach ($fields as $key => $value) {
				$sql_parts[] = "$key = ?";
				$attributes[] = $value;
			}
			$sql_part = implode(', ', $sql_parts);
			return $this->query("INSERT INTO {$this->table} SET $sql_part", $attributes, true);
		} catch (\Exception $e) {
			var_dump($e);
		}
	}
}
