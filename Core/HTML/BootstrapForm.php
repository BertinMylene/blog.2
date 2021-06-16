<?php 
namespace Core\HTML;

class BootstrapForm extends Form
{
    /**
     * Réédition de la méthode avec design Bootstrap
     * Récupération de l'input parent pour la redéfinir avec le design Boostrap
     * @param string $typeFields
     * @param string $name ID et name de l'input 
     * @param string $label = null Nom du label si différent de l'ID
     * @param array $options = [] Les options qu'on peut passer au input
     * @return string
     **/
    public function fields(string $typeFields, string $name, string $label = null, array $options = [])
    {   
        $typeFields = lcfirst($typeFields);

        $html2 = '<div class="form-group">';
        $html2 .= parent::$typeFields($name, $label, $options);
        $html2 .= '</div>';
        return $html2;
    }

    /**
     * Réédition de la méthode avec design Bootstrap
     * Récupération du submit parent pour le redéfinir avec le design Bootstrap
     * @param string $name Nom indiqué sur le bouton
     * @param string $class Type Bootstrap pour le bouton
     * @return string code HTML pour écrire le bouton
     **/
    public function submit(string $name, string $class = 'btn btn-primary')
    {
        $name = ucfirst($name);
		return "<button type='submit' class='{$class}'>{$name}</button>";
    }
}