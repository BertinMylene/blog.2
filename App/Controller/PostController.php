<?php

namespace App\Controller;

class PostController extends AppController
{
    protected $request;
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct($request)
    {
        parent::__construct($request);

        $this->loadModel('post');
        $this->loadModel('category');
    }

    /**
     * Liste l'ensemble des Posts
     **/
    public function index()
    {
        $this->app->setTitle('Derniers articles');

        $allCategories = $this->category->all();

        $lastPosts = $this->post->getLastPosts();
        //var_dump($lastPosts);
        $this->render('post.index', compact('lastPosts', 'allCategories'));
    }

    /**
     * Affiche un Post unique
     **/
    public function show()
    {
        $post = $this->post->find($_GET['id']);
        
        if ($post === false) {
            $this->error404();
        }
        
        $category = $this->category->find($post->category_id);
        
        $this->app->setTitle($post->title);

        $this->render('post.single', compact('post', 'category'));
    }

    /**
     * Affiche les posts en fonction de la catégorie
     **/
    public function category()
    {
        $allCategories = $this->category->all();

        $postsByCategory = $this->post->getPostsByCategory($_GET['id']);
        
        if (empty($postsByCategory)) {
            $this->error404();
        }
        
        $this->app->setTitle($postsByCategory[0]->category);

        $this->render('post.category', compact('allCategories', 'postsByCategory'));
    }
}