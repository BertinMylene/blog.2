<?php

namespace App\Controller\Admin;

use \Core\HTML\BootstrapForm;
use App\Manager\PostManager;

class PostController extends AppController
{
    private $postManager;

    /**
     * Initialise les Models
     **/
    public function __construct($request)
    {
        parent::__construct($request);

        $this->loadModel('post');
        $this->loadModel('category');

        $this->postManager=new PostManager($request);
    }

    /**
     * Liste l'ensemble des articles
     **/
    public function index()
    {
        $posts = $this->post->all();

        $this->render('admin.post.index', compact('post'));
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
        
        if($this->request->hasPost()){
            
            $result=$this->postManager->update($this->request->getGetValue('id'));
            
            if ($result) {
                $success = true;
            }
        }
        
        $post = $this->post->find($this->request->getGetValue('id'));
        
        $this->form = new BootstrapForm($post);
        
        if (!$post) {
            $this->error404();
        }

        $this->render('admin.post.edit', compact('title', 'category', 'success', 'post'));
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
            $result = $this->post->update('INSERT INTO `post`(`title`, `content`, `date`, `category_id`) VALUES (:title, :content, NOW(), :category_id)', $_POST);
            
            if ($result) {
                return $this->index();
            }
        }

        $this->render('admin.post.edit', compact('title', 'category'));
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