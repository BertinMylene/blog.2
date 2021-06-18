<?php

namespace Core\Controller;

abstract class Controller
{
    /**
     * @var string $viewPath Chemin par défaut des vues
     */
    protected $viewPath;
    /**
     * @var string $template Nom du template à charger
     */
    protected $template;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;

    }

    protected function render(string $nameView, array $variables = [])
    {
        try {
            ob_start();
            extract($variables);
            require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
            $content = ob_get_clean();
            require($this->viewPath . 'templates/' . $this->template . '.php');
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Permet de renvoyer sur une page 404
     * @return [type]
     */
    protected function error404()
    {
        header('HTPP/1.0 404 Not Found');
        header('Location: index.php');
    }

    /**
     * Permet l'accès à la page quand le User n'est pas Auth
     * @return [type]
     */
    protected function forbidden()
    {
        header('HTPP/1.0 403 Forbidden');
        die('Accés interdit');
    }
}
