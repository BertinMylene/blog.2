<?php

namespace App\Controller\Admin;

use \Core\Auth\DBAuth;

class AppController extends \App\Controller\AppController
{
    /**
     * Vérifie si l'utilisateur est connecté avant de pouvoir utiliser les Controller de l'admin
     **/
    public function __construct(Type $var = null)
    {
        parent::__construct();

        $auth = new DBAuth($this->app->getDb());

        if (!$auth->logged()) {
            $this->forbidden();
        }
    }
}