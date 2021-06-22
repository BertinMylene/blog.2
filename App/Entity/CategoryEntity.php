<?php

namespace App\Entity;

use Core\Entity\Entity;

/**
* Entité qui représente les éléments récupérés de la bdd
*/
class CategoryEntity extends Entity
{
    public function getUrl()
    {
        return 'index.php?p=category.single&id=' . $this->id;
    }
}