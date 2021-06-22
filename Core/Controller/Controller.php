<?php

namespace Core\Controller;

/**
 * Receives user data
 * Transmit view
 */
abstract class Controller
{
    /**
     * Default path for views
     * @var string
     */
    protected $viewPath;
    /**
     * Template to load
     * @var
     */
    protected $template;

    /**
     * initializes the parameters of the request class
     * @param mixed $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * renvoie le code à envoyer au navigateur pendant le timeout
     * @param string $nameView
     * @param array $variables
     */
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
     * 404 error
     * return index.php
     */
    protected function error404()
    {
        header('HTPP/1.0 404 Not Found');
        header('Location: index.php');
    }

    /**
     * Denies access to the user area
     */
    protected function forbidden()
    {
        header('HTPP/1.0 403 Forbidden');
        die('Accés interdit');
    }
}
