<?php

namespace Core\HTML;

/**
* Permet la création et l'affichage d'un formulaire en HTML
*/
class Form
{
    /** 
     * @var array $data Tableau de données pour récupérer les éléments en POST et les mettre dans les formulaires 
     */
	protected $data;
    

    /**
	 * Initialise les données en Post quand elles existent
	 * @param array $datas Données reçues en $_POST
	 * @return none
	 */
	public function __construct($post = [])
	{
		$this->data = $post;
	}

    /**
	 * Prépare les différentes options pour les champs
	 * @param string $name
	 * @param string|null $label
	 * @param array $options
	 * @param bool $dataCallable
	 * 
	 * @return [type]
	 */
	public function prepareFields(string $name, string $label = null, array $options = [], bool $dataCallable = true)
	{
		if ($label === null) {
			$label = $name;
		}

		$label = ucfirst($label);

		$type = (isset($options['type'])) ? $options['type'] : 'text';
		$class = (isset($options['class'])) ? $options['class'] : 'form-control';
		$rows = (isset($options['rows'])) ? $options['rows'] : '10';
		$categoryId = (isset($options['categoryId'])) ? $options['categoryId'] : '1';
		$data = (isset($options['data'])) ? $options['data'] : NULL;

            if ($dataCallable && $data === NULL) {
                if (is_object($this->data))  {
                    $data = $this->data->$name;
                } else {
                    $data = (isset($this->data[$name])) ? $this->data[$name] : null ;
                }
            }
            $return = array(
                'label' => $label,
                'name' => $name,
                'type' => $type,
                'class' => $class,
                'data' => $data,
                'rows' => $rows,
                'categoryId' => $categoryId
            );
		return $return;
	}

    /**
     * Réédition de la méthode avec design Bootstrap
     * @param string $name ID et name de l'input 
     * @param string $label = null Nom du label si différent de l'ID
     * @param array $options = [] Les options qu'on peut passer au input
	 * @return string Input à renvoyer
	 */
	public function input(string $name, string $label = null, array $options = []) 
	{
		$opt = $this->prepareFields($name, $label, $options);
		
		$html = "<label for='{$opt['name']}'>{$opt['label']}</label>";
		$html .= "<input type='{$opt['type']}' name='{$opt['name']}' id='{$opt['name']}' class='{$opt['class']}' value='{$opt['data']}'></input>";
		return $html;
	}

    /**
	 * Affiche un textArea
	 * @param string $name Nom du TextArea
	 * @param string $label=null Nom du Label si différent de TextArea
	 * @param array $options = []
	 * @return string Texte HTML du champ à afficher
	 **/
	public function textArea(string $name, string $label = null, array $options = [])
	{
		$opt = $this->prepareFields($name, $label, $options);

		$html = "<label for='{$opt['name']}'>{$opt['label']}</label>";
		$html .= "<textarea name='{$opt['name']}' id='{$opt['name']}' rows='{$opt['rows']}' class='{$opt['class']}'>{$opt['data']}</textarea>";
        return $html;
	}

    /**
	 * Affiche un Select
	 * @param string $name Nom du TextArea
	 * @param string $label=null Nom du Label si différent de TextArea
	 * @param array $options = []
	 * @return string Texte HTML du champ à afficher
	 **/
	public function select(string $name, string $label = null, array $options = [])
	{
		$opt = $this->prepareFields($name, $label, $options, false);
		$selects = $options['selects'];

		$html = "<label for='{$opt['name']}'>{$opt['label']}</label>";
		$html .= "<select name='{$opt['name']}' id='{$opt['name']}' class='{$opt['class']}'>";

		foreach ($selects as $select) {
			$html .= $this->selectOption($select->name, $select->id, $opt['categoryId']);
		}

		$html .= "</select>";
        return $html;
	}

    /**
	 * Affiche les "Options" d'un Select
	 * @param string $value Valeur à afficher
	 * @param string $id ID du champs à récupérer
	 * @param string $defaultId ID du champ par défaut
	 * @return string Texte HTML qui va afficher les champs
	 **/
	public function selectOption(string $value, string $id, string $defaultId)
	{
		$value = ucfirst($value);

		if ($id === $defaultId) {
			$selected = 'selected';
		} else {
			$selected = NULL;
		}
		return "<option value='{$id}' {$selected}>{$value}</option>";
	}

    /**
	 * Affiche un bouton
	 * @param string @name Texte du bouton
	 * @return string HTML pour créer le bouton
	 */
	public function submit(string $name)
	{
        $name = ucfirst($name);
		return "<button type='submit'>{$name}</button>";
	}
}        