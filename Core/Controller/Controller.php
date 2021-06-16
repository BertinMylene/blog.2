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


    /**
     * Appelle la vue, lui applique les variables et l'envoie à l'application
     * @param string $nameView Nom de la vue à appeler
     * @param array $variables Variables nécessaire dans la vue pour afficher les différents éléments récupérés dans les Models
     * @return [type]
     */
    protected function render(string $nameView, array $variables = [])
    {
        ob_start();
        extract($variables);
        require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
        $content = ob_get_clean();
        require ($this->viewPath . 'templates/' . $this->template . '.php');
    }

    /**
     * Permet de renvoyer sur une page 404
     * @return [type]
     */
    protected function error404(){
        header('HTPP/1.0 404 Not Found');
        header('Location: index.php');
    }

    /**
     * Permet l'accès à la page quand le User n'est pas Auth
     * @return [type]
     */
    protected function forbidden(){
        header('HTPP/1.0 403 Forbidden');
        die('Accés interdit');
    }
}