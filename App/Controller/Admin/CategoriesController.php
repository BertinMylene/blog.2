<?php

namespace App\Controller\Admin;

use \Core\HTML\BootstrapForm;

class CategoriesController extends AppController
{
    /**
     * Initialise les Models
     **/
    public function __construct()
    {
        parent::__construct();

        $this->loadModel('post');
        $this->loadModel('category');
    }

    /**
     * Liste l'ensemble des categories
     **/
    public function index()
    {
        $categories = $this->category->all();

        $this->render('admin.categories.index', compact('categories'));
    }

    /**
     * Modifie une categorie
     **/
    public function edit()
    {
        $this->app->setTitle('Modifier une catégorie');

        $title = 'Modifier la catégorie';

        $success = false;

        if (!empty($_POST)) {
            $_POST['id'] = $_GET['id'];

            $result = $this->category->update('UPDATE `categories` SET name=:name WHERE id=:id', $_POST);
            
            if ($result) {
                $success = true;
            }
        }

        $category = $this->category->find($_GET['id']);

        $this->form = new BootstrapForm($category);

        $this->render('admin.categories.edit', compact('title', 'success', 'category'));
    }

    /**
     * Ajoute une nouvelle categorie
     **/
    public function add()
    {
        $this->app->setTitle('Ajouter une catégorie');

        $title = 'Ajouter une nouvelle catégorie';

        if (!empty($_POST)) {
            $result = $this->category->update('INSERT INTO `categories`(`name`) VALUES (:name)', $_POST);
            
            if ($result) {
                return $this->index();
            }
        }

        $this->render('admin.categories.edit', compact('title'));
    }

    /**
     * Supprime une categorie
     */
    public function delete()
    {
        if (!empty($_POST)) {
            $result = $this->category->delete($_POST['id']);

            if ($result) {
                return $this->index();
            }
        }
    }
}