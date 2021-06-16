<?php

namespace App\Controller\Admin;

use \Core\HTML\BootstrapForm;

class PostsController extends AppController
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
     * Liste l'ensemble des articles
     **/
    public function index()
    {
        $posts = $this->post->all();

        $this->render('admin.posts.index', compact('posts'));
    }

    /**
     * Modifie un article
     **/
    public function edit()
    {
        $this->app->setTitle('Modifier un article');

        $title = 'Modifier l\'article';

        $success = false;
        
        $categories = $this->category->all();
        
        if (!empty($_POST)) {
            $_POST['id'] = $_GET['id'];
            
            $result = $this->post->update('UPDATE `posts` SET title=:title, content=:content, category_id=:category_id WHERE id=:id', $_POST);
            
            if ($result) {
                $success = true;
            }
        }
        
        $post = $this->post->find($_GET['id']);
        
        $this->form = new BootstrapForm($post);
        
        if (!$post) {
            $this->error404();
        }

        $this->render('admin.posts.edit', compact('title', 'categories', 'success', 'post'));
    }

    /**
     * Ajoute un nouvel article
     **/
    public function add()
    {
        $this->app->setTitle('Ajouter un article');

        $title = 'Ajouter un nouvel article';

        $categories = $this->category->all();

        if (!empty($_POST)) {
            $result = $this->post->update('INSERT INTO `posts`(`title`, `content`, `date`, `category_id`) VALUES (:title, :content, NOW(), :category_id)', $_POST);
            
            if ($result) {
                return $this->index();
            }
        }

        $this->render('admin.posts.edit', compact('title', 'categories'));
    }

    /**
     * Supprime un article
     */
    public function delete()
    {
        if (!empty($_POST)) {
            $result = $this->post->delete($_POST['id']);

            if ($result) {
                return $this->index();
            }
        }
    }
}