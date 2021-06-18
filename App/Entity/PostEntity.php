<?php

namespace App\Entity;

use Core\Entity\Entity;

class PostEntity extends Entity
{
    public function getUrl()
    {
        return 'index.php?p=post.show&id=' . $this->id;
    }

	public function getExtract() {
		return substr($this->content, 0, 100) . '...';
	}
}