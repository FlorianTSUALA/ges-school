<?php

namespace Core\HTML\Form;

/**
* Permet la création et l'affichage d'un formulaire en HTML avec le design Bootstrap
*/
class BootstrapForm 
{
    /**
     * Réédition de la méthode avec design Bootstrap
     *
     * Récupération de l'input parent pour la redéfinir avec le design Boostrap
     *
     * @param string $name ID et name de l'input 
     * @param string $label = null Nom du label si différent de l'ID
     * @param array $options = [] Les options qu'on peut passer au input
     * @return string
     **/
    public function fields(string $type, string $name, string $label = null, array $options = [], $additional_class_group='')
    {   
        $typeFields = lcfirst($type);
        $html2 = '<div class="form-group '.$additional_class_group.' ">';
        //$html2 .= parent::$typeFields($name, $label, $options );
        $html2 .= '</div>';
        return $html2;
    }

  
    public function submit(string $name, string $class = 'btn btn-primary')
    {
        $name = ucfirst($name);
		return "<button type='submit' class='{$class}'>{$name}</button>";
    }
}