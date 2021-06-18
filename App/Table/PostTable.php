<?php

namespace App\Table;

use Core\Table\Table;

/**
* Gère les articles de la bdd
*/
class PostTable extends Table
{
	/**
	 * Récupère les derniers articles accompagnés de leur catégorie
	 * @param none
	 * @return array Liste des derniers articles ou false s'il n'y a pas
	 */
	public function getLastPosts() {
		return $this->query('
			SELECT p.id, p.title, p.content, p.created_at, c.name as category
			FROM post p
			LEFT JOIN category c ON p.category_id = c.id
			ORDER BY p.created_at DESC
			');
	}

	/**
	 * Récupère tous les posts selon une category
	 * @param string $id ID de la category
	 * @return array Liste des derniers articles ou false s'il n'y en a pas
	 */
	public function getPostsByCategory(string $id) {
		return $this->query('
			SELECT p.id, p.title, p.content, p.created_at, c.name as category
			FROM post p
			LEFT JOIN category c ON p.category_id = c.id
			WHERE p.category_id=?
			ORDER BY p.created_at DESC
			', array($id));
	}
}