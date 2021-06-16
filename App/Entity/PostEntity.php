<?php

namespace App\Entity;

use Core\Entity\Entity;

/**
* Entité qui représente les éléments récupérés de la bdd
*/
class PostEntity extends Entity
{
	protected $extract;

	/**
	 * Initialise l'extract
	 * @param none
	 * @return none
	 */
	public function __construct() {
		parent::__construct();

		$this->extract = substr($this->content, 0, 100) . '...';
	}

	/**
	 * Coupe le content au bout de 100 caractères et le renvoie
	 * @param none
	 * @return string $extract
	 */
	public function getExtract() {
		return $this->extract;
	}
}