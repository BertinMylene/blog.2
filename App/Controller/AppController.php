<?php

namespace App\Controller;

use \App;
use \Core\Form\BootstrapForm;

class AppController extends \Core\Controller\Controller
{
    /** @var Object \App $app Instance du singleton App */
    protected $app;

    /** @var Object $form Instance de BootstrapForm pour créer les formulaires de modif et d'ajout */
    protected $form;

    /**
     * Initialise les variables pour cette application
     **/
    public function __construct($request)
    {
        parent::__construct($request);

        $this->template = 'default';

        $this->viewPath = ROOT . '/app/Views/';

        $this->app = App::getInstance();

        $this->form = new BootstrapForm();
    }

    /**
     * Charge les Models
     * @param string $modelName Nom du Model à charger
     * @return type
     * @throws conditon
     **/
    protected function loadModel(string $modelName)
    {
        $this->$modelName = $this->app->getTable($modelName);
    }
}