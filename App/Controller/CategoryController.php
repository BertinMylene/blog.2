<?php
namespace App\Controller;

use App\Controller\AppController;

class CategoryController extends AppController
{
    
    protected $request;

    /**
     * Initialise le Model qu'on charge dans ce controller
     **/
    public function __construct($request)
    {
        parent::__construct($request);

        $this->loadModel('post');
        $this->loadModel('category');
    }

    /**
     * Afficher les articles de La categorie sélectionnée
     * public function category() dans App\Controller\PostController.php
     */
    public function CategoryPosts()
    {
        $postsByCategory = $this->post->getPostsByCategory($this->_get);

        $this->render('category.post', compact('category'));
    }

}