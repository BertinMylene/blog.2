<?php

namespace App\Controller;

use \Core\Auth\DBAuth;
use \Core\HTML\BootstrapForm;

class UsersController extends AppController
{
    /**
     * Permet l'authentification de l'utilisateur
     **/
    public function login()
    {
        $error = false;

        if (!empty($_POST)) {
            $auth = new DBAuth($this->app->getDb());
            
            if ($auth->login($_POST['pseudo'], $_POST['mdp'])) {
                header('Location: index.php?p=admin.posts.index');
            } else {
                $error = true;
            }
        }
        $this->render('users.login', compact('error'));
    }
}