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
			SELECT posts.id, posts.title, posts.content, posts.date, categories.name as category
			FROM posts
			LEFT JOIN categories ON category_id = categories.id
			ORDER BY posts.date DESC
			');
	}

	/**
	 * Récupère tous les posts selon une category
	 * @param string $id ID de la category
	 * @return array Liste des derniers articles ou false s'il n'y en a pas
	 */
	public function getPostsByCategory(string $id) {
		return $this->query('
			SELECT posts.id, posts.title, posts.content, posts.date, categories.name as category
			FROM posts
			LEFT JOIN categories ON category_id = categories.id
			WHERE category_id=?
			ORDER BY posts.date DESC
			', array($id));
	}
}